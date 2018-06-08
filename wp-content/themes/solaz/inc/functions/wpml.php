<?php
//remove wpml language selector style
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
//remove wpml currency-switcher style
add_action('wp_print_styles', 'solaz_dequeue_css_currency_switcher', 100);

function solaz_dequeue_css_currency_switcher() {
    wp_dequeue_style('currency-switcher');
}

//show currency switcher dropdown list
function solaz_show_currencies_dropdown() {
    global $solaz_settings;
    if (class_exists('WCML_CurrencySwitcher') && class_exists('Woocommerce')) {
        global $woocommerce_wpml;
        if (!isset($woocommerce_wpml->multi_currency_support)) {
            return;
        }
        $settings = $woocommerce_wpml->get_settings();
        $current_currency = $woocommerce_wpml->multi_currency_support->get_client_currency();
        $wc_currencies = get_woocommerce_currencies();
        $format_setting = isset($settings['wcml_curr_template']) && $settings['wcml_curr_template'] != '' ? $settings['wcml_curr_template'] : '%name% (%symbol%) - %code%';
        $currency_format = preg_replace(array('#%name%#', '#%symbol%#', '#%code%#'), array($wc_currencies[$current_currency], get_woocommerce_currency_symbol($current_currency), $current_currency), $format_setting);
        ?>
            <div class="currency_custom">
                <a class="current-open" href="#" aria-expanded="false" aria-haspopup="true" data-toggle="dropdown">
                    <?php echo esc_html($currency_format);?>
                </a>
                <div class="dib header-currencies dropdown-menu">
                    <div id="currencyHolder">
                        <?php echo(do_shortcode('[currency_switcher switcher_style="list" orientation="vertical"]')); ?>
                    </div>
                </div>
            </div>
        <?php
    }
}
//show language switcher dropdown list
function solaz_show_language_dropdown() {
    global $solaz_settings, $sitepress;
    if( !defined( 'ICL_LANGUAGE_CODE' ) && !isset( $sitepress )) {
        return false;
    }
    $languages = icl_get_languages('skip_missing=0&orderby=code');
        $language_text = esc_html__('Languages', 'solaz');
        if(defined('ICL_LANGUAGE_CODE')) {
            $language_text = ICL_LANGUAGE_CODE;
        }
        ?>
        <?php if ( $solaz_settings['wpml-switcher']) :?>
        <div class="languges-flags">
            <?php 
            if(!empty($languages)){
                foreach($languages as $l){
                    if($l['active']) echo '<a class="current-open" href="#" aria-expanded="false" aria-haspopup="true" data-toggle="dropdown"><i class="fa fa-globe" aria-hidden="true"></i>';
                    if($l['active']) echo esc_html($l['language_code']);
                    if($l['active']) echo '</a>';
                }
            }
            ?>
            <div class="header-languages content-filter dropdown-menu">
                <?php do_action('icl_language_selector'); ?>
            </div>
        </div>
        <?php endif;?>
        <?php
}
//demo
function solaz_show_language_dropdown_demo(){
    global $solaz_settings, $sitepress;
    ?>
        <?php if($solaz_settings['wpml-switcher']):?>
        <div class="languges-flags">
            <a class="current-open" href="#" aria-expanded="false" aria-haspopup="true" data-toggle="dropdown"><i class="fa fa-globe" aria-hidden="true"></i><?php echo esc_html__('en', 'solaz') ?></a>
            <div class="header-languages content-filter dropdown-menu">
                <div id="lang_sel_list" class="lang_sel_list_vertical">
                    <ul>
                        <li class="icl-en"><a href="#"><?php echo esc_html__('English', 'solaz') ?></a></li>
                        <li class="icl-en"><a href="#"><?php echo esc_html__('French', 'solaz') ?></a>
                        </li>
                        <li class="icl-en"><a href="#"><?php echo esc_html__('German', 'solaz') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>  
        <?php endif;?>
    <?php
}