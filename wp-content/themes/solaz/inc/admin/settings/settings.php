<?php

/**
 * Solaz Settings Options
 */
if (!class_exists('Framework_Solaz_Settings')) {

    class Framework_Solaz_Settings {

        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }

        public function initSettings() {
            $this->ReduxFramework = new ReduxFramework($this->solaz_get_setting_sections(), $this->solaz_get_setting_arguments());
        }

        public function solaz_get_setting_sections() {
            $page_layout = solaz_layouts();
            $sidebar_positions = solaz_sidebar_position();
            $block_name = solaz_get_block_name();
            $breadcrumbs_type = solaz_get_breadcrumbs_type();
            unset($page_layout['default']);
            unset($sidebar_positions['default']);
            $menus = get_terms('nav_menu');
            $menu_list =solaz_list_menu();            
            $sections = array(
                array(
                    'icon' => 'el-icon-edit',
                    'icon_class' => 'icon',
                    'title' => esc_html__('General', 'solaz'),
                    'fields' => array(
                    )
                ),
                array(
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Layout', 'solaz'),
                'fields' => array(
                        array(
                            'id' => 'layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'solaz'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                    )
                ),
                array(
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Logo, Favicon, Js Custom', 'solaz'),
                'fields' => array(
                        array(
                            'id' => 'logo',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Logo', 'solaz'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo.png',
                                'height' => 40,
                                'wide' => 200
                            )
                        ),
                        array(
                            'id' => 'favicon',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Favicon', 'solaz'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/favicon.ico'
                            )
                        ),
                        array(
                            'id' => 'js-code',
                            'type' => 'ace_editor',
                            'title' => esc_html__('JS Code', 'solaz'),
                            'subtitle' => esc_html__('Paste your JS code here.', 'solaz'),
                            'mode' => 'javascript',
                            'theme' => 'chrome',
                            'default' => "jQuery(document).ready(function(){});"
                        )
                    )
                ),
                array(
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Preloader', 'solaz'),
                'fields' => array(
                        array(
                            'id'            => 'preload',
                            'type'          => 'button_set',
                            'title'         => esc_html__('Preload ', 'solaz'),
                            'description'   => esc_html__('Enable Preload site', 'solaz'), 
                            'options'       => array(
                                'enable'  => esc_html__( 'Enable', 'solaz' ), 
                                'disable'  => esc_html__( 'Disable', 'solaz' ),   
                            ),
                            'default'       => 'enable', 
                        ),
                    )
                ),
                array(
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('View, Language Switcher', 'solaz'),
                'fields' => array(
                        array(
                            'id'=>'wpml-switcher',
                            'type' => 'switch',
                            'title' => esc_html__('Show WPML Language Switcher', 'solaz'),
                            'desc' => esc_html__('Show wpml language switcher instead of view switcher menu.', 'solaz').' '.esc_html__('Compatible with WPML plugins.', 'solaz'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz'),
                        ),
                    )
                ),
                array(
                    'icon' => 'el-icon-css',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Skin', 'solaz'),
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('General', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'general-bg',
                            'type' => 'background',
                            'title' => esc_html__('General Background', 'solaz'),
                            'default' => array(
                                'background-color' => '#fff',
                                'background-image' => '',
                                'background-size' => 'inherit',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'inherit'
                            ),
                        ),
                        array(
                            'id' => 'general-font',
                            'type' => 'typography',
                            'title' => esc_html__('General Font', 'solaz'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'default' => array(
                                'color' => "#9c9c9c",
                                'google' => true,
                                'font-weight' => '400',
                                'font-family' => 'Poppins',
                                'font-size' => '15px',
                                'line-height' => '24px'
                            ),
                        ),
                        array(
                            'id' => 'primary-color',
                            'type' => 'color',
                            'title' => esc_html__('Primary color', 'solaz'),
                            'default' => '#b58a61',
                            'validate' => 'color',
                            'transparent' => false
                        ),
                        array(
                            'id' => 'highlight-color',
                            'type' => 'color',
                            'title' => esc_html__('Highlight color', 'solaz'),
                            'default' => '#000',
                            'validate' => 'color',
                            'description' => esc_html__('change links color when hover/active.', 'solaz'),
                            'transparent' => false
                        )
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Breadcrumbs', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'breadcrumbs-bg',
                            'type' => 'background',
                            'title' => esc_html__('Background', 'solaz'),
                            'background-color' => false,
                            'default' => array(
                                'background-color' => '#fff',
                                'background-image' => get_template_directory_uri() . '/images/bg-breadcrumb.jpg',
                                'background-size' => 'cover',
                                'background-repeat' => 'no-repeat',
                                'background-position' => 'center center',
                                'background-attachment' => 'fixed'
                            )
                        ),
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Typography', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'h1-font',
                            'type' => 'typography',
                            'title' => esc_html__('H1 Font', 'solaz'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#3d3935",
                                'google' => true,
                                'font-family' => 'Poppins',
                                'font-size' => '40px',
                            ),
                        ),
                        array(
                            'id' => 'h2-font',
                            'type' => 'typography',
                            'title' => esc_html__('H2 Font', 'solaz'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#3d3935",
                                'google' => true,
                                'font-family' => 'Poppins',
                                'font-size' => '36px',
                            ),
                        ),
                        array(
                            'id' => 'h3-font',
                            'type' => 'typography',
                            'title' => esc_html__('H3 Font', 'solaz'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#3d3935",
                                'google' => true,
                                'font-family' => 'Poppins',
                                'font-size' => '25px',
                            ),
                        ),
                        array(
                            'id' => 'h4-font',
                            'type' => 'typography',
                            'title' => esc_html__('H4 Font', 'solaz'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#3d3935",
                                'google' => true,
                                'font-family' => 'Poppins',
                                'font-size' => '18px',
                            ),
                        ),
                        array(
                            'id' => 'h5-font',
                            'type' => 'typography',
                            'title' => esc_html__('H5 Font', 'solaz'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#3d3935",
                                'google' => true,
                                'font-family' => 'Poppins',
                                'font-size' => '16px',
                            ),
                        ),
                        array(
                            'id' => 'h6-font',
                            'type' => 'typography',
                            'title' => esc_html__('H6 Font', 'solaz'),
                            'google' => true,
                            'subsets' => false,
                            'font-style' => false,
                            'text-align' => false,
                            'font-weight' => false,
                            'line-height' => false,
                            'default' => array(
                                'color' => "#3d3935",
                                'google' => true,
                                'font-family' => 'Poppins',
                                'font-size' => '14px',
                            ),
                        ),
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Custom', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'custom-css-code',
                            'type' => 'ace_editor',
                            'title' => esc_html__('CSS', 'solaz'),
                            'subtitle' => esc_html__('Enter CSS code here.', 'solaz'),
                            'mode' => 'css',
                            'theme' => 'monokai',
                            'default' => ""
                        ),
                    )
                ),
                $this->solaz_add_header_section_options(),
                array(
                    'icon_class' => 'el-icon-edit',
                    'subsection' => true,
                    'title' => esc_html__('Header Styling', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'header-style',
                            'type' => 'select',
                            'title' => esc_html__('Select header for styling', 'solaz'),
                            'options' => solaz_header_types(),
                            'default' => '1',
                        ),       
                    //Header 1& 3                     
                        array(
                            'id'       => 'logo_width',
                            'type'     => 'dimensions',
                            'units'    => array('em','px','%'),
                            'title'    => esc_html__('Set logo image max width and max height', 'solaz'),
                            'subtitle' => esc_html__('Allow users to set width and height for header logo image', 'solaz'),
                            'height'   => true,
                        ), 
                        array(
                            'id'       => 'header_logo_wrap_width',
                            'type'     => 'dimensions',
                            'units'    => array('em','px','%'),
                            'title'    => esc_html__('Set header logo container width and height', 'solaz'),
                            'height'   => true,
                            'required' => array('header-style', 'equals', array(
                                    '1',
                                )),                             
                        ),  
                        array(
                            'id'       => 'header2_logo_wrap_width',
                            'type'     => 'dimensions',
                            'units'    => array('em','px','%'),
                            'title'    => esc_html__(' Set header logo container width and height', 'solaz'),
                            'height'   => true,
                            'required' => array('header-style', 'equals', array(
                                    '2',
                                )),                             
                        ), 
                        array(
                            'id'       => 'header3_logo_wrap_width',
                            'type'     => 'dimensions',
                            'units'    => array('em','px','%'),
                            'title'    => esc_html__(' Set header logo container width and height', 'solaz'),
                            'height'   => true,
                            'required' => array('header-style', 'equals', array(
                                    '3',
                                )),                             
                        ),
                        array(
                            'id'       => 'header3_sticky_logo_wrap_width',
                            'type'     => 'dimensions',
                            'units'    => array('em','px','%'),
                            'title'    => esc_html__(' [Header sticky] Set header logo container width and height', 'solaz'),
                            'height'   => true,
                            'required' => array('header-style', 'equals', array(
                                    '3',
                                )),                             
                        ),                                                  
                        array(
                            'id'       => 'header2m_logo_wrap_width',
                            'type'     => 'dimensions',
                            'units'    => array('em','px','%'),
                            'title'    => esc_html__('[Mobile] Set header logo container width and height', 'solaz'),
                            'height'   => true,
                            'required' => array('header-style', 'equals', array(
                                    '2',
                                )),                             
                        ),                                                                          
                        array(
                            'id'             => 'menu_spacing',
                            'type'           => 'spacing',
                            'mode'           => 'margin',
                            'units'          => array('px'),
                            'units_extended' => 'false',
                            'title'          => esc_html__('Set padding for menu items', 'solaz'),
                            'subtitle'       => esc_html__('Allow users to ajust menu item spacing', 'solaz'),
                            'required' => array('header-style', 'equals', array(
                                    '1',
                                )),                                                         
                        ),                                                           
                        array(
                            'id' => 'header-top-bg',
                            'type' => 'color',
                            'title' => esc_html__('Header background color for header bottom', 'solaz'),
                            'default' => '#3d3935',
                            'validate' => 'color',
                            'subtitle' => esc_html__('Default background color is #3d3935', 'solaz'),
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1',
                                )),                            
                        ),                        
                        array(
                            'id' => 'header-bg',
                            'type' => 'color',
                            'title' => esc_html__('Header background color', 'solaz'),
                            'default' => '#fff',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1','3'
                                )),                                
                        ),                                                
                        array(
                            'id' => 'header-icon-color',
                            'type' => 'color',
                            'title' => esc_html__('Header icon color', 'solaz'),
                            'default' => '#9c9c9c',
                            'subtitle' => esc_html__('Default background color is #9c9c9c', 'solaz'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1',                              
                                )),                            
                        ), 
                        array(
                            'id' => 'header-menu',
                            'type' => 'color',
                            'title' => esc_html__('Header menu color', 'solaz'),
                            'default' => '#1f1f1f',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1',                              
                                )),                            
                        ),   
                         array(
                            'id' => 'header1-top-text',
                            'type' => 'color',
                            'title' => esc_html__('Link color for header info section', 'solaz'),
                            'default' => '#e0e0e0',
                            'subtitle' => esc_html__('Default background color is #e0e0e0', 'solaz'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                     '1'                               
                                )),                            
                        ),                                                              
                         array(
                            'id' => 'header-top-text',
                            'type' => 'color',
                            'title' => esc_html__('Link color for header info section', 'solaz'),
                            'default' => '#939393',
                            'subtitle' => esc_html__('Default background color is #939393', 'solaz'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                     '3'                               
                                )),                            
                        ),
                        array(
                            'id'       => 'header2_logo_container_bg',
                            'type' => 'color',
                            'title' => esc_html__('Set header logo container background', 'solaz'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '2',                              
                                )),                              
                        ),                           
                     //Header 3
                        array(
                            'id' => 'header3-menu',
                            'type' => 'color',
                            'title' => esc_html__('Header menu color', 'solaz'),
                            'default' => '#3d3935',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '3',                              
                                )),                            
                        ), 
                        array(
                            'id' => 'header3-icon_color',
                            'type' => 'color',
                            'title' => esc_html__('Header icon color', 'solaz'),
                            'default' => '#a1a1a1',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '3',                              
                                )),                            
                        ),  
                        array(
                            'id' => 'header3-menu_border',
                            'type' => 'color',
                            'title' => esc_html__('Header navigation border top color', 'solaz'),
                            'default' => '#ededed',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '3',                              
                                )),                            
                        ),                                                
                    //Header mobile                       
                         array(
                            'id' => 'menu-mobile-bg',
                            'type' => 'color',
                            'title' => esc_html__('[Mobile] Background color for menu in mobile', 'solaz'),
                            'default' => '#4d4d4d',
                            'subtitle' => esc_html__('Default background color is #3d3935', 'solaz'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1', '2',                                
                                )),                            
                        ), 
                         array(
                            'id' => 'menu-mobile-color',
                            'type' => 'color',
                            'title' => esc_html__('[Mobile] Menu link color in mobile', 'solaz'),
                            'default' => '#fff',
                            'subtitle' => esc_html__('Default menu link color is #fff', 'solaz'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1','3' ,'2'                                
                                )),                            
                        ), 
                         array(
                            'id' => 'menu-mobile-border',
                            'type' => 'color',
                            'title' => esc_html__('[Mobile] Menu border color in mobile', 'solaz'),
                            'default' => '#5c5c5c',
                            'subtitle' => esc_html__('Default menu link color is #5c5c5c', 'solaz'),
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '1', '2'                                
                                )),                            
                        ),                               

                    //Header 2                                                                 
                        array(
                            'id' => 'header2-menu_color',
                            'type' => 'color',
                            'title' => esc_html__('Header menu color', 'solaz'),
                            'default' => '#fff',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '2','4'                            
                                )),                            
                        ),
                        array(
                            'id' => 'header2-bg',
                            'type' => 'color',
                            'title' => esc_html__('Header background color for header', 'solaz'),
                            'default' => '#3d3935',
                            'validate' => 'color',
                            'subtitle' => esc_html__('Default background color is #3d3935', 'solaz'),
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '2','4'
                                )),                            
                        ),   
                    //Header 4
                        array(
                            'id' => 'header4-side_color',
                            'type' => 'color',
                            'title' => esc_html__('Header menu color in side-menu', 'solaz'),
                            'default' => '#1f1f1f',
                            'validate' => 'color',
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '4'                            
                                )),                            
                        ),
                        array(
                            'id' => 'header4-side_bg',
                            'type' => 'color',
                            'title' => esc_html__('Header background color in side-menu', 'solaz'),
                            'default' => '#fff',
                            'validate' => 'color',
                            'subtitle' => esc_html__('Default background color is #fff', 'solaz'),
                            'transparent' => true,
                            'required' => array('header-style', 'equals', array(
                                    '4'
                                )),                            
                        ),                                              
                    )

                ),                
                array(
                    'icon' => 'el-icon-edit',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Footer', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'footer-type',
                            'type' => 'image_select',
                            'title' => esc_html__('Footer Type', 'solaz'),
                            'options' => $this->solaz_footer_types(),
                            'default' => '1'
                        ),
                        array(
                            'id' => 'logo_footer1',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Footer logo', 'solaz'),
                            'required' => array('footer-type', 'equals', array(
                                    '1',
                                )),                            
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo_footer.png',
                            )
                        ),    
                        array(
                            'id' => 'logo_footer2',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Footer logo', 'solaz'),
                            'required' => array('footer-type', 'equals', array(
                                    '2',
                                )),                            
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo_footer2.png',
                            )
                        ),  
                        array(
                            'id' => 'logo_footer3',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Footer logo', 'solaz'),
                            'required' => array('footer-type', 'equals', array(
                                    '3',
                                )),                            
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo_footer3.png',
                            )
                        ),                                                                                               
                        array(
                            'id' => "footer-info",
                            'type' => 'textarea',
                            'title' => esc_html__('Contact Info', 'solaz'),
                            'default' => wp_kses( __('14 Tottenham Court Road, London, England - (102) 3456 789 - <a href="mailto:info@yourdomain.com">info@yourdomain.com </a>', 'solaz'), 
                                array(
                                'a' => array(
                                    'href' => array('callto'=> array()),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '1','3'
                                )
                            ),                            
                        ),                        
                        array(
                            'id' => "footer-copyright",
                            'type' => 'textarea',
                            'title' => esc_html__('Copyright', 'solaz'),
                            'default' => wp_kses( __('Copyright © 2017 Solaz Villa Hotel', 'solaz'), 
                                array(
                                'a' => array(
                                    'href' => array(),
                                    'title' => array(),
                                    'target' => array(),
                                ),
                                'i' => array(
                                    'class' => array(),
                                    'aria-hidden' => array(),
                                ),
                                )),
                            'required' => array(
                                'footer-type', 'equals',array(
                                    '1','2','3'
                                )
                            ),                            
                        ),
                    )
                ),

                array(
                    'icon_class' => 'el-icon-edit',
                    'subsection' => true,
                    'title' => esc_html__('Footer Styling', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'footer-style',
                            'type' => 'select',
                            'title' => esc_html__('Select footer for styling', 'solaz'),
                            'options' => solaz_footer_types(),
                            'default' => '1',
                        ),                         
                        array(
                            'id' => 'footer-bg',
                            'type' => 'color',
                            'title' => esc_html__('Footer background color', 'solaz'),
                            'required' => array('footer-style', 'equals', array(
                                    '1','2'
                                )),
                            'default' => '#3d3935',
                            'validate' => 'color',
                        ),

                        array(
                            'id' => 'footer-color',
                            'type' => 'color',
                            'title' => esc_html__('Footer text color', 'solaz'),
                            'required' => array('footer-style', 'equals', array(
                                    '1','3','2'
                                )),
                            'default' => '#858585',
                            'validate' => 'color',
                            'transparent' =>false,
                        ),  
                        array(
                            'id' => 'footer-t-color',
                            'type' => 'color',
                            'title' => esc_html__('Footer title color', 'solaz'),
                            'required' => array('footer-style', 'equals', array(
                                    '2'
                                )),
                            'default' => '#fff',
                            'validate' => 'color',
                            'transparent' =>false,
                        ),                         
                    //Footer 3
                        array(
                            'id' => 'footer3-bg',
                            'type' => 'color',
                            'title' => esc_html__('Footer bottom background color', 'solaz'),
                            'required' => array('footer-style', 'equals', array(
                                    '3',
                                )),
                            'default' => '#fff',
                            'validate' => 'color',
                        ),                        
                        array(
                            'id' => 'footer3-bottom-bg',
                            'type' => 'color',
                            'title' => esc_html__('Footer bottom background color', 'solaz'),
                            'required' => array('footer-style', 'equals', array(
                                    '3',
                                )),
                            'default' => '#3d3935',
                            'validate' => 'color',
                        ), 
                        array(
                            'id' => 'footer3-bottom-color',
                            'type' => 'color',
                            'title' => esc_html__('Footer bottom color', 'solaz'),
                            'required' => array('footer-style', 'equals', array(
                                    '3',
                                )),
                            'default' => '#909090',
                            'validate' => 'color',
                        ),
                        array(
                            'id' => 'footer3-bottom-hcolor',
                            'type' => 'color',
                            'title' => esc_html__('Footer bottom hover color', 'solaz'),
                            'required' => array('footer-style', 'equals', array(
                                    '3','2'
                                )),
                            'default' => '#fff',
                            'validate' => 'color',
                        ),                                                                                       
                    )
                ),                
                array(
                    'icon' => 'el-icon-th',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Blog & Single Blog', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => '1',
                            'type' => 'info',
                            'desc' => esc_html__('Blog layout default', 'solaz')
                        ),
                        array(
                            'id' => 'post-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'solaz'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-post-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-post-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
						array(
                            'id' => 'post-layout-version',
                            'type' => 'button_set',
                            'title' => esc_html__('Blog Layout', 'solaz'),
                            'options' => solaz_page_blog_layouts(),
                            'default' => 'list'
                        ),
						array(
                            'id' => 'post-layout-columns',
                            'type' => 'button_set',
                            'title' => esc_html__('Blog Columns', 'solaz'),
                            'options' => solaz_page_blog_columns(),
                            'default' => '1'
                        ),
                        array(
                            'id' => 'blog-title',
                            'type' => 'text',
                            'title' => esc_html__('Page Title', 'solaz'),
                            'default' => 'Blog'
                        ),
                    )
                ),
                array(
                    'icon' => 'el-icon-picture',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Gallery', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => '2',
                            'type' => 'info',
                            'desc' => esc_html__('Gallery Archive Page', 'solaz')
                        ),
                        array(
                            'id'        => 'gallery_slug',
                            'type'      => 'text',
                            'title'     => esc_html__('Custom Slug', 'solaz'),
                            'subtitle'  => esc_html__('If you want your gallery post type to have a custom slug in the url, please enter it here.', 'solaz'),
                            'desc'      => esc_html__('You will still have to refresh your permalinks after saving this! 
    This is done by going to Settings > Permalinks and clicking save.', 'solaz'),
                            'validate'  => 'str_replace',
                            'str'       => array(
                                'search'        => ' ', 
                                'replacement'   => '-'
                            ),
                            'default'   => 'gallery',                    
                        ),  
                        array(
                            'id'        => 'gallery_cat_slug',
                            'type'      => 'text',
                            'title'     => esc_html__('Custom Slug for Gallery category', 'solaz'),
                            'subtitle'  => esc_html__('If you want your gallery category to have a custom slug in the url, please enter it here.', 'solaz'),
                            'desc'      => esc_html__('You will still have to refresh your permalinks after saving this! 
    This is done by going to Settings > Permalinks and clicking save.', 'solaz'),
                            'validate'  => 'str_replace',
                            'str'       => array(
                                'search'        => ' ', 
                                'replacement'   => '-'
                            ),
                            'default'   => 'gallery_cat',                    
                        ),                         
                        array(
                            'id' => 'gallery-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'solaz'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-gallery-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-gallery-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'gallery-cols',
                            'type' => 'button_set',
                            'title' => esc_html__('Gallery Columns', 'solaz'),
                            'options' => solaz_gallery_columns(),
                            'default' => '3',
                        ),
                        array(
                            'id' => 'gallery-style-version',
                            'type' => 'button_set',
                            'title' => esc_html__('Gallery layouts', 'solaz'),
                            'options' => solaz_page_gallery_layouts(),
                            'default' => '1'
                        ),                        
                        array(
                            'id' => 'gallery-loadmore-style',
                            'type' => 'button_set',
                            'title' => esc_html__('Gallery loadmore style', 'solaz'),
                            'options' => array(
                                '1' => esc_html__('Button style 1','solaz'),
                                '2' => esc_html__('Button style 2','solaz'),
                                ),
                            'default' => '1',                         
                        ), 
                        array(
                            'id'       => 'gallery_per_page',
                            'type'     => 'spinner', 
                            'title'    => esc_html__('Post show per page', 'solaz'),
                            'default'  => '6',
                            'min'      => '1',
                            'step'     => '1',
                            'max'      => '20',
                        )                       
                    )
                ),
                array(
                    'icon' => 'el-icon-shopping-cart',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Shop', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'product-cart',
                            'type' => 'switch',
                            'title' => esc_html__('Show Add to Cart button', 'solaz'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz')
                        ),
                        array(
                            'id' => 'product-price',
                            'type' => 'switch',
                            'title' => esc_html__('Show Product Price', 'solaz'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz')
                        ),                        
                        array(
                            'id' => 'product-label',
                            'type' => 'switch',
                            'title' => esc_html__('Show Product Label', 'solaz'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz'),
                        ),
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Product listing', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => '1',
                            'type' => 'info',
                            'desc' => esc_html__('Product listing', 'solaz')
                        ),
                        array(
                            'id' => 'shop-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'solaz'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-shop-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-shop-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'category-item',
                            'type' => 'text',
                            'title' => esc_html__('Products per Page', 'solaz'),
                            'desc' => esc_html__('Comma separated list of product counts.', 'solaz'),
                            'default' => '8,16,24'
                        ),
						array(
                            'id' => 'product-layouts',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Layouts', 'solaz'),
                            'options' => solaz_product_type(),
                            'default' => 'only-grid',
                        ),
                        array(
                            'id' => 'product-cols',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Columns', 'solaz'),
                            'options' => solaz_product_columns(),
                            'default' => '4',
                            'required' => array('product-layouts', 'equals', array(
                                    'only-grid'
                                )),                             
                        ),
                        array(
                            'id' => 'product-wishlist',
                            'type' => 'switch',
                            'title' => esc_html__('Show Wishlist', 'solaz'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz'),
                        ), 
						array(
                            'id' => 'product-pagination',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Pagination', 'solaz'),
                            'default' => true,
                            'options' => solaz_pagination_types(),
                            'default' => 'loadmore'
                        ),
                    )
                ),
                array(
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Single Product', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'single-product-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'solaz'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        array(
                            'id' => 'left-single-product-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Left Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
                        array(
                            'id' => 'right-single-product-sidebar',
                            'type' => 'select',
                            'title' => esc_html__('Select Right Sidebar', 'solaz'),
                            'data' => 'sidebars',
                            'default' => ''
                        ),
						array(
                            'id' => 'product-share',
                            'type' => 'switch',
                            'title' => esc_html__('Show Product share link', 'solaz'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz'),
                        ),   
                        array(
                            'id' => 'product-related',
                            'type' => 'switch',
                            'title' => esc_html__('Show Related Products', 'solaz'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz'),
                        ),
                    )
                ),
                array(
                    'icon' => 'el el-calendar',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Hotel Booking', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'room-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Layout', 'solaz'),
                            'options' => $page_layout,
                            'default' => 'fullwidth'
                        ),
                        
                        array(
                            'id' => 'single-room-layout',
                            'type' => 'button_set',
                            'title' => esc_html__('Single Room Layout', 'solaz'),
                            'options' => $page_layout,
                            'default' => 'wide'
                        ),

                        array(
                            'id' => 'hotel-type-pagination',
                            'type' => 'button_set',
                            'title' => esc_html__('Hotel Pagination', 'solaz'),
                            'default' => true,
                            'options' => solaz_pagination_types(),
                            'default' => 'loadmore'
                        ),
                    )
                ),
                array(
                    'icon' => 'el-icon-cog',
                    'icon_class' => 'icon',
                    'title' => esc_html__('404 Page', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => '404-bg-image',
                            'type' => 'media',
                            'url' => true,    
                            'readonly' => false,
                            'title' => esc_html__('Background image', 'solaz'),
                            'desc' => esc_html__('Background image for 404 page', 'solaz'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/background_404.jpg',
                            )
                        ),
                    )
                ),                        
                array(
                    'icon' => 'el-icon-cog',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Coming soon', 'solaz'),
                    'fields' => array(
                        array(
                            'id' => 'under-contr-mode',
                            'type' => 'switch',
                            'title' => esc_html__('Activate under construction mode', 'solaz'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz'),
                        ),
                       array(
                            'id' => 'under-bg-image',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Background image', 'solaz'),
                            'desc' => esc_html__('Background image for comming soon page', 'solaz'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/coming-soon.jpg',
                            )
                        ),
                        array(
                            'id' => 'logo-coming',
                            'type' => 'media',
                            'url' => true,
                            'readonly' => false,
                            'title' => esc_html__('Logo display in coming soon page', 'solaz'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/images/logo_footer.png',
                                'height' => 115,
                                'wide' => 115
                            )
                        ),
                        array(
                            'id' => "under-contr-title",
                            'type' => 'text',
                            'title' => esc_html__('Big Title', 'solaz'),
                            'default' => esc_html__('Sailing includes blank pages so you can build all kinds of awesome stuff as coming soon page!', 'solaz')
                        ),
                        array(
                            'id' => '1',
                            'type' => 'info',
                            'desc' => esc_html__('Countdown Timer', 'solaz')
                        ),
                        array(
                            'id' => 'under-display-countdown',
                            'type' => 'switch',
                            'title' => esc_html__('Display countdown timer', 'solaz'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz'),
                        ),
                         array(
                            'id' => "under-end-date",
                            'type' => 'date',
                            'title' => esc_html__('End date', 'solaz'),
                            'default' => '',
                            'required' => array('under-display-countdown', 'equals', true),
                        ),
                        array(
                            'id' => 'under-mail',
                            'type' => 'switch',
                            'title' => esc_html__('Display subcribe form', 'solaz'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'solaz'),
                            'off' => esc_html__('No', 'solaz'),
                        ),
                    )
                ),
            );
            return $sections;
        }

        protected function solaz_add_header_section_options() {
            $header = array(
                'icon' => 'el-icon-edit',
                'icon_class' => 'icon',
                'title' => esc_html__('Header', 'solaz'),
                'fields' => array(
                    array(
                        'id' => 'header-type',
                        'type' => 'image_select',
                        'title' => esc_html__('Header Type', 'solaz'),
                        'options' => $this->solaz_header_types(),
                        'default' => '2'
                    ),
                    array(
                        'id' => 'logo4',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo for header 4', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '4'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo4.png',
                            'height' => 86,
                            'wide' => 85
                        )
                    ),                                                      
                    array(
                        'id' => 'logo3',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo for header 3', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '3'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo3.png',
                            'height' => 120,
                            'wide' => 120
                        )
                    ),
                    array(
                        'id' => 'logo2',
                        'type' => 'media',
                        'url' => true,
                        'readonly' => false,
                        'title' => esc_html__('Logo for header 2', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '2'
                                )),
                            ),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo2.png',
                            'height' => 120,
                            'wide' => 120
                        )
                    ),                    
                    array(
                        'id' => 'header_email',
                        'type' => 'text',
                        'title' => esc_html__('Email Infomation', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1','3'
                                )),
                            ),
                        'default' => esc_html__(' accsupport@gmail.com', 'solaz'),
                    ),
                    array(
                       'id' => 'section-start',
                       'type' => 'section',
                       'title' => esc_html__('Location Info', 'solaz'),
                       'indent' => true,
                        'required' => array(
                                array('header-type', 'equals', array(
                                '1','3'
                            )),
                        ),                       
                    ),                     
                    array(
                        'id' => 'header_location',
                        'type' => 'text',
                        'title' => esc_html__('Location Infomation', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1','3'
                                )),
                            ),
                        'default' => esc_html__('How to find us?', 'solaz'),
                    ),  
                    array(
                        'id' => 'header_location_url',
                        'type' => 'text',
                        'title' => esc_html__('Enter link for "How to find us" block', 'solaz'),
                        'default' => '#',
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1','3'
                                )),
                            ),                        
                        'subtitle' => esc_html__('Enter link for "How to find us" block', 'solaz')
                    ), 
                    array(
                        'id'     => 'section-end',
                        'type'   => 'section',
                        'indent' => false,
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1','3'
                                )),
                            ),                        
                    ),                       
                    array(
                        'id' => 'header_phone_text',
                        'type' => 'text',
                        'title' => esc_html__('Header text before phone number', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1','2','3'
                                )),
                            ),
                        'default' => esc_html__('', 'solaz'),
                    ),                                       
                    array(
                        'id' => 'header_phone',
                        'type' => 'text',
                        'title' => esc_html__('Phone Number', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1','2','3'
                                )),
                            ),
                        'default' => esc_html__('', 'solaz'),
                    ),                     
                    array(
                        'id' => 'header_gallery',
                        'type' => 'text',
                        'title' => esc_html__('Enter gallery text', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1','3'
                                )),
                            ),
                        'default' => esc_html__('View Our Gallery', 'solaz'),
                    ),                     
                    array(
                        'id' => 'header_gallery_url',
                        'type' => 'text',
                        'title' => esc_html__('Enter gallery link', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1','3'
                                )),
                            ),
                        'default' => esc_html__('#', 'solaz'),
                    ),                   
                    array(
                        'id' => 'header_book_text',
                        'type' => 'text',
                        'title' => esc_html__('"Book Now" box', 'solaz'),
                        'default' => esc_html__('Book Now', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1'
                                )),
                            ),                        
                        'subtitle' => esc_html__('Enter text for "Book Now" block', 'solaz')
                    ), 
                    array(
                        'id' => 'header_book_link',
                        'type' => 'text',
                        'title' => esc_html__('Enter Book Now link', 'solaz'),
                        'required' => array(
                                    array('header-type', 'equals', array(
                                    '1',
                                )),
                            ),
                    ),                                   
                    array(
                        'id' => 'header-minicart',
                        'type' => 'switch',
                        'title' => esc_html__('Show minicart', 'solaz'),
                        'required' => array('header-type', 'equals', array(
                                '1','2','3'
                            )),                         
                        'default' => true
                    ),                    
                    array(
                        'id' => 'header-search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search', 'solaz'),
                        'required' => array('header-type', 'equals', array(
                                '1','2','3'
                            )),                         
                        'default' => true
                    ),   
                    array(
                        'id' => 'header4-search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search', 'solaz'),
                        'required' => array('header-type', 'equals', array(
                                '4',
                            )),                         
                        'default' => false
                    ),                                                        
                    array(
                        'id' => 'header-sticky',
                        'type' => 'switch',
                        'title' => esc_html__('Enable sticky', 'solaz'),
                        'default' => true
                    ),   
                    array(
                        'id' => 'header-sticky-mobile',
                        'type' => 'switch',
                        'required' => array('header-sticky', 'equals', 1,),
                        'title' => esc_html__('Enable sticky on mobile ', 'solaz'),
                        'default' => true
                    ),                
                ),
            );

            return $header;
        }

        public function solaz_get_setting_arguments() {
            $theme = wp_get_theme();
            $args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'solaz_settings',
                'display_name' => esc_html__('Solaz', 'solaz'),
                'display_version' => $theme->get('Version'),
                'menu_type' => 'menu',
                'allow_sub_menu' => true,
                'menu_title' => esc_html__('Solaz', 'solaz'),
                'page_title' => esc_html__('Solaz', 'solaz'),
                'google_api_key' => '',
                'google_update_weekly' => false,
                'async_typography' => true,
                'admin_bar' => true,
                'admin_bar_icon' => 'dashicons-admin-generic',
                'admin_bar_priority' => 50,
                'global_variable' => '',
                'dev_mode' => false,
                'update_notice' => true,
                'customizer' => true,
                'page_priority' => null,
                'page_parent' => 'themes.php',
                'page_permissions' => 'manage_options',
                'menu_icon' => '',
                'last_tab' => '',
                'page_icon' => 'icon-themes',
                'page_slug' => '',
                'save_defaults' => true,
                'default_show' => false,
                'default_mark' => '',
                'show_import_export' => true,
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                'output_tag' => true,
                'database' => '',
                'use_cdn' => true,
                // HINTS
                'hints' => array(
                    'icon' => 'el el-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'red',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => '',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave',
                        ),
                    ),
                )
            );
            return $args;
        }

        protected function solaz_header_types() {
            return array(
                '1' => array('alt' => esc_html__('Header Type 1', 'solaz'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-1.jpg'),
                '2' => array('alt' => esc_html__('Header Type 2', 'solaz'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-2.jpg'),
                '3' => array('alt' => esc_html__('Header Type 3', 'solaz'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-3.jpg'),
                '4' => array('alt' => esc_html__('Header Type 4', 'solaz'), 'img' => get_template_directory_uri() . '/inc/admin/settings/headers/header-4.jpg'),                                           
            );
        }

        protected function solaz_footer_types() {
            return array(
                '1' => array('alt' => esc_html__('Footer Type 1', 'solaz'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-1.jpg'),
                '2' => array('alt' => esc_html__('Footer Type 2', 'solaz'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-2.jpg'),
                '3' => array('alt' => esc_html__('Footer Type 3', 'solaz'), 'img' => get_template_directory_uri() . '/inc/admin/settings/footers/footer-3.jpg'),            
            );
        }

    }

    
    function solaz_get_framework_settings() {
        global $solazReduxSettings;
        $solazReduxSettings = new Framework_Solaz_Settings();
        return $solazReduxSettings;
    }
    solaz_get_framework_settings();
}