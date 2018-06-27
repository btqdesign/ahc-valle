<?php
/**
 * Plugin Name: BTQ Design Booking IP
 * Plugin URI: http://btqdesign.com/plugins/btq-booking-ip/
 * Description: Booking Internet Power
 * Version: 0.1.0
 * Author: BTQ Design
 * Author URI: http://btqdesign.com/
 * Requires at least: 4.9.6
 * Tested up to: 4.9.6
 * 
 * Text Domain: btq-booking-ip
 * Domain Path: /languages
 * 
 * @package btq-booking-ip
 * @category Core
 * @author BTQ Design
 */


// Exit if accessed directly
defined('ABSPATH') or die('No script kiddies please!');

/** 
 * Establece el dominio correcto para la carga de traducciones
 */
load_plugin_textdomain('btq-booking-ip', false, basename( dirname( __FILE__ ) ) . '/languages');

/**
 * Almacena en un archivo el contenido de una variable.
 *
 * Con el proposito de poder depurar el código es necesario poder
 * conocer el resultado de cadenas de caracteres, arreglos, consultas 
 * y funciones, por ello esta funcion almacena en un archvo adentro
 * adentro de la carpeta "log" del plugin el contenido de la 
 * variable que se indique en el paramento $var .
 *
 * @author Saúl Díaz
 * @access public
 * @param string $file_name Nombre del archivo .log
 * @param string $var Variable a depurar, si es diferente a tipo 
 *		cadena la pasa por la función var_export
 * @param bool $same_file El valor predeterminado false indica que 
 * 		cada vez que se llama la función crea un nuevo archivo .log . 
 * 		El valor true utiliza el mismo archivo .log .
 * @return file Escribe en el archivo .log el contenido de la variable.
 */ 
function btq_booking_ip_log($file_name, $var, $same_file = false){
	$log_dir = plugin_dir_path( __FILE__ ) . 'log' ;
	
	if (!file_exists($log_dir)) {
		mkdir($log_dir, 0755);
	}
	
	if(is_string($var)){
		$string = $var;
	}
	else {
		$string = var_export($var, TRUE);
	}
	
	if ($same_file){
		$file_path = $log_dir . DIRECTORY_SEPARATOR . $file_name . '.log';
		file_put_contents($file_path, date('[Y-m-d H:i:s] ') . $string . "\n", FILE_APPEND | LOCK_EX);
	}
	else {
		$file_path = $log_dir . DIRECTORY_SEPARATOR . $file_name . date('-Ymd-U'). '.log';
		file_put_contents($file_path, $string);
	}
}

/**
 * Genera un elemento en el menú del escritorio del wp-admin de WordPress.
 *
 * El menú generado llama la funcion que genera la página de ajustes y la
 * página del depurador.
 * 
 * @author Saúl Díaz
 * @return void Genera el menú y sub-menú en el escritorio del wp-admin de
 * 		WordPress.
 */
function btq_booking_ip_admin_menu() {
    add_menu_page(
        __('Booking IP', 'btq-booking-ip'),
        __('Booking IP', 'btq-booking-ip'),
        'manage_options',
        'btq_booking_ip_admin',
        'btq_booking_ip_admin_page',
        'dashicons-building',
        100
    );
    add_submenu_page(
    	'btq_booking_ip_settings', 
    	__('Settings', 'btq-booking-ip'), 
    	__('Settings', 'btq-booking-ip'), 
    	'manage_options', 
    	'btq_booking_ip_admin',
    	'btq_booking_ip_admin_admin_page'
    );
    /* Manda a llamar la funcion para declarar los ajustes y opciones del plug-in */
    //add_action( 'admin_init', 'btq_booking_ip_register_settings' );
}
add_action('admin_menu', 'btq_booking_ip_admin_menu');

function btq_booking_ip_admin_admin_page(){
?>
	<div class="wrap">
		<h1>Booking Internet Power Admin</h1>
		<pre><?php echo htmlentities( btq_booking_ip_query_url('ValleDeMexico', '6422', '2689', 'es-MX', '2018-11-21', '2018-11-22', 'MXN', 1, 1, 0) ); ?></pre>
		<?php
			$result = btq_booking_ip_query('ValleDeMexico', '6422', '2689', 'es-MX', '2018-11-21', '2018-11-22', 'MXN', 1, 1, 0);
			$resultVarExport = var_export($result, TRUE);
		?>
		<pre><?php echo htmlentities($resultVarExport); ?></pre>
	</div>
<?php
}

/**
 * Genera la URL de consulta al booking de Internet Power.
 *
 * La URL devuelve un JSON con las habitaciones
 * 
 * @author Saúl Díaz
 * @param string $app Código de app
 * @param string $propertyNumber Número de propiedad
 * @param string $partnerId Identificador de asociado
 * @param string $lang Código ISO de idioma
 * @param string $checkIn Fecha de entrada
 * @param string $checkOut Fecha de salida
 * @param string $currency Código ISO de moneda
 * @param int $rooms Número de habitaciones
 * @param int $adults Número de adultos
 * @param int $children Número de niños
 * @return string URL a consultar
 */
function btq_booking_ip_query_url($app, $propertyNumber, $partnerId, $lang, $checkIn, $checkOut, $currency, $rooms, $adults, $children){
	//https://secure.internetpower.com.mx/portals/DinamicRooms/Request.ashx?propertyNumber=6422&currency=USD&app=ValleDeMexico&Rooms=1&PartnerId=2689&StartDay=1&Nights=1&adults=1&lang=en-US&CheckIn=20180424&CheckOut=20180425&Children=0
	$dateCheckIn  = new DateTime($checkIn);
	$dateCheckOut = new DateTime($checkOut);
	if ($dateCheckIn < $dateCheckOut) {
		$nights = $dateCheckOut->diff($dateCheckIn)->format("%a"); 
		$url = 
			'https://secure.internetpower.com.mx/portals/DinamicRooms/Request.ashx?'
			.'propertyNumber=' . $propertyNumber
			.'&currency=' . $currency
			.'&app=' . $app
			.'&Rooms=' . $rooms
			.'&PartnerId=' . $partnerId
			.'&StartDay=1'
			.'&Nights=' . $nights
			.'&adults=' . $adults
			.'&lang=' . $lang
			.'&CheckIn=' . str_replace('-', '', $checkIn)
			.'&CheckOut=' . str_replace('-', '', $checkOut)
			.'&Children='.$children;
		
		return $url;
	}
	else {
		return FALSE;
	}
}

function btq_booking_ip_query($app, $propertyNumber, $partnerId, $lang, $checkIn, $checkOut, $currency, $rooms, $adults, $children){
	$urlQuery = btq_booking_ip_query_url($app, $propertyNumber, $partnerId, $lang, $checkIn, $checkOut, $currency, $rooms, $adults, $children);
	$resultJSON = file_get_contents($urlQuery);
	$resultArray = json_decode($resultJSON);
	return $resultArray;
}