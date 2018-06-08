<?php 
function solaz_scripts_styles() {
    wp_enqueue_style( 'solaz-fonts', solaz_fonts_url(), array(), null );
    global $solaz_settings;
    $solaz_custom_css ='';
    if(isset($solaz_settings['under-bg-image']) && $solaz_settings['under-bg-image']!='' && $solaz_settings['under-bg-image']['url']){
        $solaz_custom_css .= "
            .page-coming-soon{
                background: url({$solaz_settings['under-bg-image']['url']});   
                background-size: cover; background-position: 50% 50%;
            }
        ";         
    }
    if(isset($solaz_settings['404-bg-image']) && $solaz_settings['404-bg-image'] !='' && $solaz_settings['404-bg-image']['url']){
        $solaz_custom_css .= "
            .page-404{
                background: url({$solaz_settings['404-bg-image']['url']});   
                background-size: cover; background-position: bottom center;
            }
        ";         
    }
    if(isset($solaz_settings['logo_width']) && $solaz_settings['logo_width']!=''){
        if(isset($solaz_settings['logo_width']['height']) && $solaz_settings['logo_width']['height']!=''){
            $solaz_custom_css .= "
                .site-header .header-logo img{
                    height: {$solaz_settings['logo_width']['height']} !important;
                }
            ";              
        }
        if(isset($solaz_settings['logo_width']['width']) && $solaz_settings['logo_width']['width']!=''){
            $solaz_custom_css .= "
                .site-header .header-logo img{
                    width: {$solaz_settings['logo_width']['width']} !important;
                }
            ";
        }         
    }
    if(isset($solaz_settings['header_logo_wrap_width']) && $solaz_settings['header_logo_wrap_width']!=''){
        if(isset($solaz_settings['header_logo_wrap_width']['height']) && $solaz_settings['header_logo_wrap_width']['height']!=''){
            $solaz_custom_css .= "
                @media (min-width: 992px){
                    .header-v1 .header-logo{
                        height: {$solaz_settings['header_logo_wrap_width']['height']} !important;
                    }
                }
            ";              
        }
        if(isset($solaz_settings['header_logo_wrap_width']['width']) && $solaz_settings['header_logo_wrap_width']['width']!=''){
            $solaz_custom_css .= "
                @media (min-width: 992px){
                    .header-v1 .header-logo{
                        width: {$solaz_settings['header_logo_wrap_width']['width']} !important;
                    }
                    .header-v1 .header-right {
                        width: calc(100% - {$solaz_settings['header_logo_wrap_width']['width']});
                    } 
                }               
            ";
        }         
    }   
    if(isset($solaz_settings['header3_logo_wrap_width']) && $solaz_settings['header3_logo_wrap_width']!=''){
        if(isset($solaz_settings['header3_logo_wrap_width']['height']) && $solaz_settings['header3_logo_wrap_width']['height']!=''){
            $solaz_custom_css .= "
                @media (min-width: 1200px){
                    .header-v3 .header-logo{
                        height: {$solaz_settings['header3_logo_wrap_width']['height']} !important;
                    }
                }
            ";              
        }
        if(isset($solaz_settings['header3_logo_wrap_width']['width']) && $solaz_settings['header3_logo_wrap_width']['width']!=''){
            $solaz_custom_css .= "
                @media (min-width: 1200px){
                    .header-v3 .header-logo{
                        width: {$solaz_settings['header3_logo_wrap_width']['width']} !important;
                    }
                }               
            ";
        }         
    }     
    if(isset($solaz_settings['header3_sticky_logo_wrap_width']) && $solaz_settings['header3_sticky_logo_wrap_width']!=''){
        if(isset($solaz_settings['header3_sticky_logo_wrap_width']['height']) && $solaz_settings['header3_sticky_logo_wrap_width']['height']!=''){
            $solaz_custom_css .= "
                @media (min-width: 1200px){
                    .header-v3.site-header .nav-sections-2 .header-logo{
                        height: {$solaz_settings['header3_sticky_logo_wrap_width']['height']} !important;
                    }
                }
            ";              
        }
        if(isset($solaz_settings['header3_sticky_logo_wrap_width']['width']) && $solaz_settings['header3_sticky_logo_wrap_width']['width']!=''){
            $solaz_custom_css .= "
                @media (min-width: 1200px){
                    .header-v3.site-header .nav-sections-2 .header-logo{
                        width: {$solaz_settings['header3_sticky_logo_wrap_width']['width']} !important;
                    }
                    .header-v3.site-header .nav-sections-2 .header-logo img{
                        width: 100% !important;
                    }
                }               
            ";
        }         
    }    
    if(isset($solaz_settings['header2_logo_wrap_width']) && $solaz_settings['header2_logo_wrap_width']!=''){
        if(isset($solaz_settings['header2_logo_wrap_width']['height']) && $solaz_settings['header2_logo_wrap_width']['height']!=''){
            $solaz_custom_css .= "
                @media (min-width: 1200px){
                    .header-v2 .header-logo{
                        height: {$solaz_settings['header2_logo_wrap_width']['height']} !important;
                    }
                }
            ";              
        }
        if(isset($solaz_settings['header2_logo_wrap_width']['width']) && $solaz_settings['header2_logo_wrap_width']['width']!=''){
            $solaz_custom_css .= "
                @media (min-width: 1200px){
                    .header-v2 .header-logo{
                        width: {$solaz_settings['header2_logo_wrap_width']['width']} !important;
                    }
                    .header-v2 .header-center {
                        padding-left: calc({$solaz_settings['header2_logo_wrap_width']['width']} - 150px);
                        margin-left: 0;
                    } 
                    .header-v2 #site-navigation {
                        padding-left: 15px;
                    }                                        
                }               
            ";
            if(is_rtl()){
                $solaz_custom_css .= "
                    @media (min-width: 1200px){
                        .header-v2 .header-center {
                            padding-right: {$solaz_settings['header2_logo_wrap_width']['width']};
                            margin-right: 0;
                        } 
                        .header-v2 #site-navigation {
                            padding-right: 15px;
                        }                         
                    }               
                ";
            }
        }         
    }   
    if(isset($solaz_settings['header2m_logo_wrap_width']) && $solaz_settings['header2m_logo_wrap_width']!=''){
        if(isset($solaz_settings['header2m_logo_wrap_width']['height']) && $solaz_settings['header2m_logo_wrap_width']['height']!=''){
            $solaz_custom_css .= "
                @media (max-width: 767px){
                    .header-v2 .header-logo{
                        height: {$solaz_settings['header2m_logo_wrap_width']['height']} !important;
                    }
                }
            ";              
        }
        if(isset($solaz_settings['header2m_logo_wrap_width']['width']) && $solaz_settings['header2m_logo_wrap_width']['width']!=''){
            $solaz_custom_css .= "
                @media (max-width: 767px){
                    .header-v2 .header-logo{
                        width: {$solaz_settings['header2m_logo_wrap_width']['width']} !important;
                        max-width: none !important;
                    }                                        
                }               
            ";
        }         
    } 
    if(isset($solaz_settings['header2_logo_container_bg']) && $solaz_settings['header2_logo_container_bg']){
        $solaz_custom_css .= "
            .header-v2 .header-logo {
               background: {$solaz_settings['header2_logo_container_bg']} !important;
            }
        ";        
    }      
    if(isset($solaz_settings['header-top-text']) && $solaz_settings['header-top-text']!= ''){
        $solaz_custom_css .= "
            .link-contact a {
               color: {$solaz_settings['header-top-text']};
            }
        ";
    }
    if(isset($solaz_settings['header1-top-text']) != ''){
        $solaz_custom_css .= "
            .header-v1 .link-contact a {
               color: {$solaz_settings['header1-top-text']};
            }
        ";
    }    
    if(isset($solaz_settings['header-top-bg'])){
        $solaz_custom_css .= "
            .header-v1 .header-bottom, .header-v1 .header-logo {
                background-color: {$solaz_settings['header-top-bg']};
            }
            @media (max-width:767px){
                header{
                    background-color: {$solaz_settings['header-top-bg']} !important;
                }
            }
        ";
    } 
    
    if(isset($solaz_settings['header-icon-color'])){
        $solaz_custom_css .= "
            .header-v1 .languges-flags a,
            header-v1 .search-block-top, header-v1 .mini-cart{
                color: {$solaz_settings['header-icon-color']};
            }
        ";
    }     
    if(isset($solaz_settings['header-menu'])){
        $solaz_custom_css .= "
            .main-navigation .ubermenu-skin-none > ul > li > .ubermenu-target,
            .mega-menu > li > a{
                color: {$solaz_settings['header-menu']};
            }
            @media (max-width:767px){
                header:not(.header-v4) .mega-menu > li > a{
                    color: {$solaz_settings['header-menu']} !important;
                    border: none;
                }
                header.header-v4 .main-navigation .ubermenu-skin-none > ul > li > .ubermenu-target{
                    color: {$solaz_settings['header-menu']} !important;
                    border: none !important;
                }
            }            
            
        ";
    } 
    if(isset($solaz_settings['header-icon-color'])){
        $solaz_custom_css .= "
            header .search-block-top, header .mini-cart > a,.btn-open,
                .header-v1 .languges-flags > a, .header-v1 .mini-cart{
                color: {$solaz_settings['header-icon-color']};
            }
        ";        
    }
    if(isset($solaz_settings['menu-mobile-bg'])){
        $solaz_custom_css .= "
            @media (max-width:767px){
                .nav-sections,.section-nav-title li a:hover, .section-nav-title li a.active{
                    background: {$solaz_settings['menu-mobile-bg']} !important;
                }
            }
        ";        
    }
    if(isset($solaz_settings['header3-menu'])){
        $solaz_custom_css .= "
            .header-v3 .mega-menu > li > a, .header-v3 .main-navigation .ubermenu-skin-none > ul > li > .ubermenu-target{
                color: {$solaz_settings['header3-menu']} !important;
                border: none !important;
            }
        ";         
    }
    if(isset($solaz_settings['header3-icon_color'])){
        $solaz_custom_css .= "
            @media (min-width:768px){
                .header-v3 .languges-flags a, .header-v3 .search-block-top, .header-v3 .mini-cart > a{
                    color: {$solaz_settings['header3-icon_color']} !important;
                }
            }
        ";         
    }    
    if(isset($solaz_settings['header3-menu_border'])){
        $solaz_custom_css .= "
            @media (min-width:1199px){
                ..header-v3:not(.is-sticky) #site-navigation{
                    border-top-color: {$solaz_settings['header3-menu_border']} !important;
                }
            }
        ";         
    }    
    if(isset($solaz_settings['header2-bg']) || isset($solaz_settings['header2-menu_color'])){
        $solaz_custom_css .= "
            .header-v2 .mega-menu > li > a,
            .header-v2 .main-navigation .ubermenu-skin-none > ul > li > .ubermenu-target,
            .header-v2 .link-contact a,
            .header-v2, .header-v2 .search-block-top, .header-v2 .languges-flags > a,
            .btn-open-menu, .header-v4 .search-block-top{
                color: {$solaz_settings['header2-menu_color']} !important;
            }
            .header-v2, .header-v4{
                background: {$solaz_settings['header2-bg']} !important;
            }
        ";         
    }
    if(isset($solaz_settings['menu-mobile-color'])){
        $solaz_custom_css .= "
            @media (max-width:767px){
                header:not(.header-v4) .mega-menu > li > a{
                    color: {$solaz_settings['menu-mobile-color']} !important;
                    border-color: {$solaz_settings['menu-mobile-color']} !important;
                }
                header .search-block-top, header .mini-cart > a,.btn-open,
                .languges-flags > a,
                .main-navigation .ubermenu-skin-none > ul > li > .ubermenu-target,
                header.header-v3.site-header .header_right_link > div.mini-cart > a{
                    color: {$solaz_settings['menu-mobile-color']} !important;
                }
                .ubermenu .ubermenu-submenu .ubermenu-target,
                .mega-menu .dropdown-menu li a{
                    color: {$solaz_settings['menu-mobile-color']};
                }
            }
        ";        
    }
    if(isset($solaz_settings['menu-mobile-border'])){
        $solaz_custom_css .= "
            @media (max-width:767px){
                .mega-menu > li > a, .section-nav-title li{
                    border-color: {$solaz_settings['menu-mobile-border']} !important;
                }
            }
        ";        
    }
    $footer_type = solaz_get_footer_type();
    $solaz_f_d_bg = $solaz_settings['footer-bg'];
    $solaz_f_d_color = $solaz_settings['footer-color'];
    if($footer_type == '3'){
        $solaz_f_d_bg = $solaz_settings['footer3-bg'];
    }
    $footer_text_color = (solaz_get_meta_value('footer_text_color') != '') ? solaz_get_meta_value('footer_text_color') : $solaz_f_d_color;
    $solaz_footer_bg = (solaz_get_meta_value('footer_bg') != '') ? solaz_get_meta_value('footer_bg') : $solaz_f_d_bg;
    $solaz_header_bg = (solaz_get_meta_value('header_bg') != '') ? solaz_get_meta_value('header_bg') : '';        
    if(isset($solaz_footer_bg) && $solaz_footer_bg!='' ){
        $solaz_custom_css .= "
            .footer > div, .footer-v3 .footer-top{
                background: {$solaz_footer_bg} !important;
            }
        ";          
    }
    if(isset($solaz_header_bg) && $solaz_header_bg != ''){
        $solaz_custom_css .= "
            header:not(.is-sticky):not(.header-v4) #site-navigation, header:not(.is-sticky){
                background: {$solaz_header_bg} !important;
            }
        ";         
    }
    if(isset($footer_text_color) && $footer_text_color!=''){
        $solaz_custom_css .= "
            .footer > div, .footer-v3 a,footer a
            {
                color: {$footer_text_color} !important;
            }
        ";          
    } 
    if(isset($solaz_settings['footer3-bottom-bg']) || isset($solaz_settings['footer3-bottom-color'])){
        $solaz_custom_css .= "
            .footer-v3 .footer-bottom, .footer-v3 .footer-bottom a,
            .footer-v3 .footer-bottom p{
                color: {$solaz_settings['footer3-bottom-color']} !important;
            }
            .footer-v3 .footer-bottom{
                background: {$solaz_settings['footer3-bottom-bg']} !important;
            }
        ";        
    } 
    if(isset($solaz_settings['header4-side_color']) || isset($solaz_settings['header4-side_bg'])){
        $solaz_custom_css .= "
            .header-v4 .main-navigation{
                background: {$solaz_settings['header4-side_bg']} !important;
            }
            .header-v4 .main-navigation .ubermenu .ubermenu-submenu .ubermenu-target, .header-v4 .main-navigation .mega-menu .dropdown-menu li a,
            .header-v4 .mega-menu > li > a{
                color: {$solaz_settings['header4-side_color']} !important;
            }
        ";         
    }
    if(isset($solaz_settings['footer-t-color'])){
        $solaz_custom_css .= "
            .footer .footer-title{
                color: {$solaz_settings['footer-t-color']} !important;
            }
        ";        
    }
    if(isset($solaz_settings['footer3-bottom-hcolor'])){
        $solaz_custom_css .= "
            .footer-v3 .footer-bottom a:hover,.footer-v2 a:hover,
            .footer-v1 a:hover{
                color: {$solaz_settings['footer3-bottom-hcolor']} !important;
            }
            .footer .widget_nav_menu div > ul > li a:hover {
                border-bottom: 2px solid {$solaz_settings['footer3-bottom-hcolor']} !important;
            }
        ";         
    }
    $solaz_breadcrumbs_bg = get_post_meta(get_the_ID(), 'breadcrumbs_bg', true);
    $solaz_breadcrumbs_color = get_post_meta(get_the_ID(), 'breadcrumbs_color', true);
    if ($solaz_breadcrumbs_bg != '') {
        $solaz_custom_css .="
        .side-breadcrumb{
            background-image: url({$solaz_breadcrumbs_bg}) !important;
        }
        ";
    }   
    if ($solaz_breadcrumbs_color != '') {
        $solaz_custom_css .="
        .side-breadcrumb h1 {
            color: {$solaz_breadcrumbs_color} !important;
        }
        ";
    }      
      
    //Load font icon css
    
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css?ver=' . SOLAZ_VERSION); 
    wp_enqueue_style('foodfarm-font-common', get_template_directory_uri() . '/css/icomoon.css?ver=' . SOLAZ_VERSION); 
    wp_enqueue_style('dashicons', get_template_directory_uri() . '/css/dashicons.css?ver=' . SOLAZ_VERSION);    
    wp_enqueue_style('pe-icon-7-stroke', get_template_directory_uri() . '/css/pe-icon/pe-icon-7-stroke.css?ver=' . SOLAZ_VERSION);    
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/plugin/bootstrap.min.css?ver=' . SOLAZ_VERSION);
    wp_enqueue_style('fancybox', get_template_directory_uri() . '/css/plugin/jquery.fancybox.css?ver=' . SOLAZ_VERSION);
    wp_enqueue_style('slick', get_template_directory_uri() . '/css/plugin/slick.css?ver=' . SOLAZ_VERSION);    
    
    wp_enqueue_style('solaz-animate', get_template_directory_uri() . '/css/animate.min.css?ver=' . SOLAZ_VERSION);
    if (is_rtl()) {
        //Load theme RTL css
        wp_enqueue_style('solaz-theme-rtl', get_template_directory_uri() . '/css/theme_rtl.css?ver=' . SOLAZ_VERSION);
         wp_add_inline_style( 'solaz-theme-rtl', $solaz_custom_css );
    }
    else{
        //Load theme css
        wp_enqueue_style('solaz-theme', get_template_directory_uri() . '/css/theme.css?ver=' . SOLAZ_VERSION);
        wp_add_inline_style( 'solaz-theme', $solaz_custom_css );
    }
    // Load skin stylesheet
    wp_enqueue_style('solaz-skin', get_template_directory_uri() . '/css/config/skin.css?ver=' . SOLAZ_VERSION);
    // custom styles
    wp_deregister_style( 'solaz-style' );
    wp_register_style( 'solaz-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'solaz-style' );

    if (is_rtl()) {
        wp_deregister_style( 'solaz-style-rtl' );
        wp_register_style( 'solaz-style-rtl', get_template_directory_uri() . '/style_rtl.css' );
        wp_enqueue_style( 'solaz-style-rtl' );
    }

}
add_action('wp_enqueue_scripts', 'solaz_scripts_styles');