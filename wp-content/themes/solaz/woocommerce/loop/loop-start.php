<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
?>


<?php 
global $wp_query;
$solaz_settings = solaz_check_theme_options();
$cat = $wp_query->get_queried_object();
if(isset($cat->term_id)){
	$woo_cat = $cat->term_id;
}else{
	$woo_cat = '';
}
$product_layout = isset($solaz_settings['product-layouts']) ? $solaz_settings['product-layouts'] :'';
$product_list_mode = get_metadata('product_cat', $woo_cat, 'list_mode_product', true);
$product_type_class = '';
if($product_list_mode == "only-grid"){
	$product_type_class = "product-grid";
}
else if(($product_list_mode == "only-list") || ($product_layout == "only-list")) {
	$product_type_class = "product-list";
}
else{
	$product_type_class = "product-grid";
}
?>
<div class="product-entries-wrap isotope <?php echo esc_attr($product_type_class);?>">
