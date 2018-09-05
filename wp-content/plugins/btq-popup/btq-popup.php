<?php
/**
 * Plugin Name: BTQ Popup
 * Plugin URI: https://granhotel.idevol.net/wp-content/plugins/btq-popup/btq-popup.html
 * Description: Popup autodesplegable.
 * Version: 1.0
 * Author: BTQ Design
 * Author URI: http://btqdesign.com/
 * Requires at least: 4.9.7
 * Tested up to: 4.9.7
 * 
 * Text Domain: btq-popup
 * Domain Path: /languages
 * 
 * @package btq-popup
 * @category Core
 * @author BTQ Design
 */


// Exit if accessed directly
defined('ABSPATH') or die('No script kiddies please!');

/** 
 * Establece el dominio correcto para la carga de traducciones
 */
load_plugin_textdomain('btq-popup', false, basename( dirname( __FILE__ ) ) . '/languages');

/**
 * Añade a WordPress los assets JS y CSS necesarios para el Grid.
 *
 * @author José Antonio del Carmen
 * @return void Integra CSS y JS al frond-end del sitio.
 */
function btq_popup_scripts() {
	if (!is_admin()) {
		wp_enqueue_script( 'btq-popup', plugins_url( 'assets/js' . DIRECTORY_SEPARATOR . 'btq-popup.js', __FILE__ ), array(), '1.0');
		wp_enqueue_style( 'btq-popup-css', plugins_url( 'assets/css' . DIRECTORY_SEPARATOR . 'btq-style.css', __FILE__ ), array(),'1.0.0');
	}
}
add_action( 'wp_enqueue_scripts', 'btq_popup_scripts',1004);

/*
 * Añade el popup modal en el footer de la página.
 *
 * @author José Antonio del Carmen
 * @return string Imprime el código html del popup modal.
 */
function btq_popup() {
	$language = btq_popup_current_language_code();
	?>
	<!-- BTQ Popup -->
	<div class="modal fade" id="Top5razones" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered btq-popup" role="document">
			<div class="modal-content">
				<div class="modal-header">			
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div style="padding: 0px;" class="modal-body">
					<?php if (isMobile == false): ?>

						<?php if ($language == 'es'): ?>
						<img src="<?php echo plugins_url( 'imagenes/header_mob.jpg', __FILE__ ); ?>" alt="Top 5 razones por las que conviene reservar.">
						<?php else: ?>
						<img src="<?php echo plugins_url( 'imagenes/header_mob_en.jpg', __FILE__ ); ?>" alt="Top 5 reasons why you should book.">
						<?php endif; ?>
						<?php if ($language == 'es'): ?>
						<a href="https://granhoteldelaciudaddemexico.com.mx/es/conoce-los-beneficios-de-reservar-con-nosotros/"><img src="<?php echo plugins_url( 'imagenes/body_mob.jpg', __FILE__ ); ?>" alt="Top 5 razones por las que conviene reservar."></a>
						<?php else: ?>
						<a href="https://granhoteldelaciudaddemexico.com.mx/en/learn-about-the-benefits-of-booking-with-us/"><img src="<?php echo plugins_url( 'imagenes/body_mob_en.jpg', __FILE__ ); ?>" alt="Top 5 reasons why you should book."></a>
						<?php endif; ?>

					<?php else: ?>
						<?php if ($language == 'es'): ?>
						<img src="<?php echo plugins_url( 'imagenes/header_web.jpg', __FILE__ ); ?>" alt="Top 5 razones por las que conviene reservar.">
						<?php else: ?>
						<img src="<?php echo plugins_url( 'imagenes/header_web_en.jpg', __FILE__ ); ?>" alt="Top 5 reasons why you should book.">
						<?php endif; ?>
						<?php if ($language == 'es'): ?>
						<a href="https://granhoteldelaciudaddemexico.com.mx/es/conoce-los-beneficios-de-reservar-con-nosotros/"><img src="<?php echo plugins_url( 'imagenes/body_web.jpg', __FILE__ ); ?>" alt="Top 5 razones por las que conviene reservar."></a>
						<?php else: ?>
						<a href="https://granhoteldelaciudaddemexico.com.mx/en/learn-about-the-benefits-of-booking-with-us/"><img src="<?php echo plugins_url( 'imagenes/body_web_en.jpg', __FILE__ ); ?>" alt="Top 5 reasons why you should book."></a>
						<?php endif; ?>

					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<!-- BTQ Popup -->
	<?php
}
add_action('wp_footer', 'btq_popup');

/**
 * Devuelve el código de idioma que se está utilizando.
 *
 * @author Saúl Díaz
 * @return string Código de idioma que se está utilizando.
 */
function btq_popup_current_language_code() {

  $wpml_current_language = apply_filters( 'wpml_current_language', NULL );
  if (!empty($wpml_current_language)){
    $language = $wpml_current_language;
  }
  elseif ( defined( 'ICL_LANGUAGE_CODE' ) ) {
    $language = ICL_LANGUAGE_CODE;
  }
  else {
    $language = 'es';
  }
  
  return $language;
}