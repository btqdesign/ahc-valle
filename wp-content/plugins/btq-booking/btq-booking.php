<?php
/**
 * Plugin Name: BTQ Booking
 * Plugin URI: http://btqdesign.com/plugins/btq-booking/
 * Description: Booking TravelClick & Internet Power Hotel
 * Version: 1.0
 * Author: BTQ Design
 * Author URI: http://btqdesign.com/
 * Requires at least: 4.9.7
 * Tested up to: 4.9.7
 * 
 * Text Domain: btq-booking
 * Domain Path: /languages
 * 
 * @package btq-booking
 * @category Core
 * @author BTQ Design
 */


// Exit if accessed directly
defined('ABSPATH') or die('No script kiddies please!');

/** 
 * Establece el dominio correcto para la carga de traducciones
 */
load_plugin_textdomain('btq-booking', false, basename( dirname( __FILE__ ) ) . '/languages');

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
function btq_booking_log($file_name, $var, $same_file = false){
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
 * Añade el enlace de ajustes en la pagina de plugins
 * 
 * @author Saúl Díaz
 * @return void Añade el enlace de ajustes en la pagina de plugins
 */
function btq_booking_add_settings_link($links) {
    $settings_link = '<a href="admin.php?page=btq_booking_settings">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'btq_booking_add_settings_link' );

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
function btq_booking_admin_menu() {
    if(btq_booking_tc_validate_saved_settings()){
	    $menu_slug      = 'btq_booking_rooms';
	    $menu_function  = 'btq_booking_admin_rooms_page';
    }
    else {
	    $menu_slug      = 'btq_booking_settings';
	    $menu_function  = 'btq_booking_admin_settings_page';
    }
    
    add_menu_page(
        __('BTQ Booking', 'btq-booking'),
        __('BTQ Booking', 'btq-booking'),
        'manage_options',
        $menu_slug,
        $menu_function,
        'dashicons-building',
        100
    );
    
    if(btq_booking_tc_validate_saved_settings()){
	    add_submenu_page(
	    	$menu_slug, 
	    	__('Rooms', 'btq-booking'), 
	    	__('Rooms', 'btq-booking'), 
	    	'manage_options', 
	    	'btq_booking_rooms',
	    	'btq_booking_admin_rooms_page'
	    );
	    add_submenu_page(
	    	$menu_slug, 
	    	__('Packages', 'btq-booking'), 
	    	__('Packages', 'btq-booking'), 
	    	'manage_options', 
	    	'btq_booking_packages',
	    	'btq_booking_admin_packages_page'
	    );
	    add_submenu_page(
	    	$menu_slug, 
	    	__('Dates without availability', 'btq-booking'), 
	    	__('Dates without availability', 'btq-booking'), 
	    	'manage_options', 
	    	'btq_booking_unavailable_dates',
	    	'btq_booking_admin_generate_unavailable_dates_page'
	    );
    }
    
    add_submenu_page(
    	$menu_slug, 
    	__('Settings', 'btq-booking'), 
    	__('Settings', 'btq-booking'), 
    	'manage_options', 
    	'btq_booking_settings',
    	'btq_booking_admin_settings_page'
    );
    
    add_submenu_page(
    	$menu_slug, 
    	__('IPH Test', 'btq-booking'), 
    	__('IPH Test', 'btq-booking'), 
    	'manage_options', 
    	'btq_booking_iph_test',
    	'btq_booking_iph_test_page'
    );
    
    /* Manda a llamar la funcion para declarar los ajustes y opciones del plug-in */
    add_action( 'admin_init', 'btq_booking_register_settings' );
}
add_action( 'admin_menu', 'btq_booking_admin_menu' );

function btq_booking_iph_test_page(){
?>
	<div class="wrap">
		<h1>Internet Power Hotel Test</h1>
		<pre><?php echo htmlentities( btq_booking_iph_query_url('ValleDeMexico', '6422', '2689', 'en-US', btq_booking_grid_date_start(), btq_booking_grid_date_end(btq_booking_grid_date_start()), 'USD', 1, 1, 0) ); ?></pre>
		<?php
			$result = btq_booking_iph_query('ValleDeMexico', '6422', '2689', 'en-US', btq_booking_grid_date_start(), btq_booking_grid_date_end(btq_booking_grid_date_start()), 'USD', 1, 1, 0);
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
function btq_booking_iph_query_url($app, $propertyNumber, $partnerId, $lang, $checkIn, $checkOut, $currency, $rooms, $adults, $children){
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
		
		// Debug
		btq_booking_log('btq_booking_iph_query_url', $url, true);
		
		return $url;
	}
	else {
		return FALSE;
	}
}

function btq_booking_iph_query($app, $propertyNumber, $partnerId, $lang, $checkIn, $checkOut, $currency, $rooms, $adults, $children){
	$urlQuery = btq_booking_iph_query_url($app, $propertyNumber, $partnerId, $lang, $checkIn, $checkOut, $currency, $rooms, $adults, $children);
	$resultJSON = file_get_contents($urlQuery);
	$resultArray = json_decode($resultJSON);
	return $resultArray;
}

/**
 * Declara los ajustes y opciones del plug-in
 */
function btq_booking_register_settings() {
	register_setting('btq-booking-settings', 'btq_booking_color_principal');
	register_setting('btq-booking-settings', 'btq_booking_service');
	
	register_setting('btq-booking-settings', 'btq_booking_tc_soap_sales_channel_info_id');
	register_setting('btq-booking-settings', 'btq_booking_tc_soap_username');
	register_setting('btq-booking-settings', 'btq_booking_tc_soap_password');
	register_setting('btq-booking-settings', 'btq_booking_tc_soap_to_action_pals');
	register_setting('btq-booking-settings', 'btq_booking_tc_soap_to_action_full');
	register_setting('btq-booking-settings', 'btq_booking_tc_hotel_code_us', array('type' => 'integer'));
	register_setting('btq-booking-settings', 'btq_booking_tc_hotel_code_es', array('type' => 'integer'));
	register_setting('btq-booking-settings', 'btq_booking_tc_hotel_themeid_us', array('type' => 'integer'));
	register_setting('btq-booking-settings', 'btq_booking_tc_hotel_themeid_es', array('type' => 'integer'));
}

/**
 * Genera la página de ajustes para el plugin.
 *
 * @author Saúl Díaz
 * @return void Genera la pagina de ajustes del plugin.
 */
function btq_booking_admin_settings_page() {
?>
	<div class="wrap">
		<h1><?php _e('BTQ Booking Settings','btq-booking'); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'btq-booking-settings' ); ?>
			<?php do_settings_sections( 'btq-booking-settings' ); ?>
			<?php submit_button(); ?>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_color_principal"><?php _e('Default color', 'btq-booking'); ?></label></th>
						<td><input type="text" id="btq_booking_color_principal" name="btq_booking_color_principal" value="<?php echo esc_attr( get_option('btq_booking_color_principal') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Booking service', 'btq-booking'); ?></th>
						<td>
							<input type="radio" id="btq_booking_service_tc" name="btq_booking_service" value="tc" <?php checked('tc', get_option('btq_booking_service')); ?>><label for="btq_booking_service_tc">Travel Click</label><br>
							<input type="radio" id="btq_booking_service_iph" name="btq_booking_service" value="iph" <?php checked('iph', get_option('btq_booking_service')); ?>><label for="btq_booking_service_iph">Internet Power Hotel</label>
						</td>
					</tr>
				</tbody>
			</table>
			<table class="form-table" id="btq_booking_tc_form_settings">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_soap_sales_channel_info_id"><?php _e('Sales channel info ID', 'btq-booking'); ?></label></th>
						<td><input type="text" class="regular-text" id="btq_booking_tc_soap_sales_channel_info_id" name="btq_booking_tc_soap_sales_channel_info_id" value="<?php echo esc_attr( get_option('btq_booking_tc_soap_sales_channel_info_id') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_soap_username"><?php _e('Username', 'btq-booking'); ?></label></th>
						<td><input type="text" class="regular-text" id="btq_booking_tc_soap_username" name="btq_booking_tc_soap_username" value="<?php echo esc_attr( get_option('btq_booking_tc_soap_username') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_soap_password"><?php _e('Password', 'btq-booking'); ?></label></th>
						<td><input type="password" class="regular-text" id="btq_booking_tc_soap_password" name="btq_booking_tc_soap_password" value="<?php echo esc_attr( get_option('btq_booking_tc_soap_password') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_soap_to_action_pals"><?php _e('SOAP Action PALS To', 'btq-booking'); ?></label></th>
						<td><input type="url" class="regular-text" id="btq_booking_tc_soap_to_action_pals" name="btq_booking_tc_soap_to_action_pals" value="<?php echo esc_attr( get_option('btq_booking_tc_soap_to_action_pals') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_soap_to_action_full"><?php _e('SOAP Action FULL To', 'btq-booking'); ?></label></th>
						<td><input type="url" class="regular-text" id="btq_booking_tc_soap_to_action_full" name="btq_booking_tc_soap_to_action_full" value="<?php echo esc_attr( get_option('btq_booking_tc_soap_to_action_full') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_hotel_code_us"><?php _e('Hotel code english language', 'btq-booking'); ?></label></th>
						<td><input type="number" class="regular-text" id="btq_booking_tc_hotel_code_us" name="btq_booking_tc_hotel_code_us" value="<?php echo esc_attr( get_option('btq_booking_tc_hotel_code_us') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_hotel_code_es"><?php _e('Hotel code spanish language', 'btq-booking'); ?></label></th>
						<td><input type="number" class="regular-text" id="btq_booking_tc_hotel_code_es" name="btq_booking_tc_hotel_code_es" value="<?php echo esc_attr( get_option('btq_booking_tc_hotel_code_es') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_hotel_themeid_us"><?php _e('Theme id english language', 'btq-booking'); ?></label></th>
						<td><input type="number" class="regular-text" id="btq_booking_tc_hotel_themeid_us" name="btq_booking_tc_hotel_themeid_us" value="<?php echo esc_attr( get_option('btq_booking_tc_hotel_themeid_us') ); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="btq_booking_tc_hotel_themeid_es"><?php _e('Theme id spanish language', 'btq-booking'); ?></label></th>
						<td><input type="number" class="regular-text" id="btq_booking_tc_hotel_themeid_es" name="btq_booking_tc_hotel_themeid_es" value="<?php echo esc_attr( get_option('btq_booking_tc_hotel_themeid_es') ); ?>" /></td>
					</tr>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	</div><!-- wrap -->
<?php
}

/**
 * Añade scripts personalizados en las páginas de ajustes.
 *
 * @author Saúl Díaz
 * @param array $hook Arreglo con los enlaces bajo el titulo del plugin.
 * @return void
 */
function btq_booking_admin_scripts($hook) {
    if(is_admin()) {      
        // Color Picker
        wp_enqueue_style('wp-color-picker'); 
        wp_enqueue_script('btq-booking-admin-js', plugins_url('assets/js' . DIRECTORY_SEPARATOR . 'btq-booking-admin.js', __FILE__), array('wp-color-picker'), false, true); 
    }
}
add_action('admin_enqueue_scripts', 'btq_booking_admin_scripts');

/**
 * Valida que las opciones necesarias esten almacenadas en la base de datos.
 *
 * @author Saúl Díaz
 * @return bool Devuelve true en caso de que las opciones estan almacenadas.
 */
function btq_booking_tc_validate_saved_settings() {
	$out = true;
	if (
		get_option('btq_booking_tc_soap_sales_channel_info_id') === false
		|| get_option('btq_booking_tc_soap_username') === false
		|| get_option('btq_booking_tc_soap_password') === false
		|| get_option('btq_booking_tc_soap_to_action_pals') === false
		|| get_option('btq_booking_tc_soap_to_action_full') === false
		|| get_option('btq_booking_tc_hotel_code_us') === false
		|| get_option('btq_booking_tc_hotel_code_es') === false
		|| get_option('btq_booking_tc_hotel_themeid_us') === false
		|| get_option('btq_booking_tc_hotel_themeid_es') === false
	){
		$out = false;
	}
	return $out;
}

/**
 * Genera un arreglo con las fechas de los días entre dos fechas distintas.
 *
 * @author Saúl Díaz
 * @param string $dateRangeStart Fecha de inicio en formato 'Y-m-d'
 * @param string $dateRangeEnd Fecha fin en formato 'Y-m-d'
 * @return array
 */
function btq_booking_grid_dates($dateRangeStart, $dateRangeEnd) {
	$begin = new DateTime($dateRangeStart);
	$end = new DateTime($dateRangeEnd);
	$end = $end->modify('+1 day'); 
	
	$interval = new DateInterval('P1D');
	$daterange = new DatePeriod($begin, $interval ,$end);
	
	return $daterange;
}

/**
 * Genera la consulta SOAP en el booking de TravelClick.
 *
 * @author Saúl Díaz
 * @param string $hotelCode Código de hotel en TravelClick.
 * @param string $dateRangeStart Fecha de llegada.
 * @param string $dateRangeEnd Fecha de salida.
 * @param string $typeQuery Tipo de consulta: habitaciones o paquetes.
 * @param int $rooms Cantidad de habitaciones.
 * @param int $adults Cantidad de adultos.
 * @param int $childrens Cantidad de niños.
 * @param string $availRatesOnly Valor booleano 'true' o 'false' para
 *		la consulta de habitaciones disponibles.
 * @return string Consulta SOAP.
 */
function btq_booking_soap_query_string($hotelCode, $dateRangeStart, $dateRangeEnd, $typeQuery = 'rooms', $rooms = 1, $adults = 1, $childrens = 0, $availRatesOnly = 'true') {
	
	if ($typeQuery == 'packages'){
		// Paquete
		$wsaTo = esc_attr( get_option('btq_booking_tc_soap_to_action_full') ); /* https://ota2.ihotelier.com/OTA_Seamless/services/FullDataService */
		$wsaAction = 'FULL';
		
		$soapBody = '
		<soap:Body>
			<OTA_HotelAvailRQ Version="2.0" AvailRatesOnly="'. $availRatesOnly .'">
				<POS>
					<Source>
						<RequestorID ID="1" Type="1" />
						<BookingChannel Type="18">
							<CompanyName Code="'. esc_attr( get_option('btq_booking_tc_soap_sales_channel_info_id') ) .'" />
						</BookingChannel>
					</Source>
				</POS>
				<AvailRequestSegments>
					<AvailRequestSegment ResponseType="FullList">
						<HotelSearchCriteria AvailableOnlyIndicator="false">
							<Criterion>
								<StayDateRange Start="'. $dateRangeStart .'" End="'. $dateRangeEnd .'" />
								<RatePlanCandidates>
									<RatePlanCandidate RatePlanType="11">
										<HotelRefs>
											<HotelRef HotelCode="'. $hotelCode .'" />
										</HotelRefs>
									</RatePlanCandidate>
								</RatePlanCandidates>
								<RoomStayCandidates>
									<RoomStayCandidate Quantity="'. $rooms .'">
										<GuestCounts>
											<GuestCount AgeQualifyingCode="10" Count="'. $adults .'" />
											<GuestCount AgeQualifyingCode="8" Count="'. $childrens .'" />
										</GuestCounts>
									</RoomStayCandidate>
								</RoomStayCandidates>
							</Criterion>
						</HotelSearchCriteria>
					</AvailRequestSegment>
				</AvailRequestSegments>
			</OTA_HotelAvailRQ>
		</soap:Body>';
	}
	else{
		// Habitaciones
		$wsaTo = esc_attr( get_option('btq_booking_tc_soap_to_action_pals') ); /* https://ota2.ihotelier.com/OTA_Seamless/services/PropertyAvailabilityService */
		$wsaAction = 'PALS';
		
		$soapBody = '
		<soap:Body>
			<OTA_HotelAvailRQ Version="2.0" AvailRatesOnly="'. $availRatesOnly .'">
				<POS>
					<Source>
						<RequestorID ID="1" Type="1" />
						<BookingChannel Type="18">
							<CompanyName Code="'. esc_attr( get_option('btq_booking_tc_soap_sales_channel_info_id') ) .'" />
						</BookingChannel>
					</Source>
				</POS>
				<AvailRequestSegments>
					<AvailRequestSegment ResponseType="PropertyList">
						<HotelSearchCriteria AvailableOnlyIndicator="true">
							<Criterion>
								<StayDateRange Start="'. $dateRangeStart .'" End="'. $dateRangeEnd .'" />
								<RatePlanCandidates>
									<RatePlanCandidate>
										<HotelRefs>
											<HotelRef HotelCode="'. $hotelCode .'"/>
										</HotelRefs>
									</RatePlanCandidate>
								</RatePlanCandidates>
								<RoomStayCandidates>
									<RoomStayCandidate Quantity="'. $rooms .'">
										<GuestCounts>
											<GuestCount AgeQualifyingCode="10" Count="'. $adults .'" />
											<GuestCount AgeQualifyingCode="8" Count="'. $childrens .'" />
										</GuestCounts>
									</RoomStayCandidate>
								</RoomStayCandidates>
							</Criterion>
						</HotelSearchCriteria>
						<TPA_Extensions>
							<InventoryData InventoryDataNeeded="True"/>
						</TPA_Extensions>                    
					</AvailRequestSegment>
				</AvailRequestSegments>
			</OTA_HotelAvailRQ>
		</soap:Body>';
	}
	
	$soapHeader = '
		<soap:Header>
			<wsa:MessageID>Message01</wsa:MessageID>
			<wsa:ReplyTo>
				<wsa:Address>NOT NEEDED FOR SYNC REQUEST</wsa:Address>
			</wsa:ReplyTo>
			<wsa:To>'. $wsaTo .'</wsa:To>
			<wsa:Action>'. $wsaAction .'</wsa:Action>
			<wsa:From>
				<SalesChannelInfo ID="'. esc_attr( get_option('btq_booking_tc_soap_sales_channel_info_id') ) .'" />
			</wsa:From>
			<wsse:Security>
				<wsu:Timestamp>
					<wsu:Created>2011-12-24T16:05:30+05:30</wsu:Created>
					<wsu:Expires>2011-12-25T16:12:46+05:30</wsu:Expires>
				</wsu:Timestamp>
				<wsse:UsernameToken>
					<wsse:Username>'. esc_attr( get_option('btq_booking_tc_soap_username') ) .'</wsse:Username>
					<wsse:Password>'. esc_attr( get_option('btq_booking_tc_soap_password') ) .'</wsse:Password>
				</wsse:UsernameToken>
			</wsse:Security>
		</soap:Header>';
	    
	$soapEnvelope = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsa="http://schemas.xmlsoap.org/ws/2004/08/addressing" xmlns:wsse="http://docs.oasisopen.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasisopen.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
        '.$soapHeader.'
        '.$soapBody.'
	</soap:Envelope>';
	
	// Debug Log
	//btq_booking_log('soapenvelope', $soapEnvelope);
	
	return array('envelope' => $soapEnvelope, 'wsaTo' => $wsaTo);
	
}

/**
 * Realiza la consulta SOAP a TravelClick
 *
 * @author Saúl Díaz
 * @param string $hotelCode Código de hotel en TravelClick.
 * @param string $dateRangeStart Fecha de llegada.
 * @param string $dateRangeEnd Fecha de salida.
 * @param string $typeQuery Tipo de consulta: habitaciones o paquetes.
 * @param int $rooms Cantidad de habitaciones.
 * @param int $adults Cantidad de adultos.
 * @param int $childrens Cantidad de niños.
 * @param string $availRatesOnly Valor booleano 'true' o 'false' para
 *		la consulta de habitaciones disponibles.
 * @return array Resultado de la consulta SOAP.
 */
function btq_booking_soap_query($hotelCode, $dateRangeStart, $dateRangeEnd, $typeQuery = 'rooms', $rooms = 1, $adults = 1, $childrens = 0, $availRatesOnly = 'true'){
	require_once('lib/nusoap.php');
	
	$soap = btq_booking_soap_query_string($hotelCode, $dateRangeStart, $dateRangeEnd, $typeQuery, $rooms, $adults, $childrens, $availRatesOnly);
	
	$client = new nusoap_client($soap['wsaTo']);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = FALSE;
	$result = $client->send($soap['envelope'], $soap['wsaTo'], '');
	
	// Captura de errores
	if (isset($result['Errors'])) {
		$errors = $result['Errors'];
		error_log('Error Code: '. $errors['Error']['!Code'] .' - '. $errors['Error']['!ShortText']);
		return FALSE;
	}
	
	return $result;
}

/**
 * Realiza la consulta SOAP a TravelClick y devuelve el resultado
 *
 * @author Saúl Díaz
 * @param string $hotelCode Código de hotel en TravelClick.
 * @param string $dateRangeStart Fecha de llegada.
 * @param string $dateRangeEnd Fecha de salida.
 * @param string $typeQuery Tipo de consulta: habitaciones o paquetes.
 * @param int $rooms Cantidad de habitaciones.
 * @param int $adults Cantidad de adultos.
 * @param int $childrens Cantidad de niños.
 * @param string $availRatesOnly Valor booleano 'true' o 'false' para
 *		la consulta de habitaciones disponibles.
 * @return array Resultado de la consulta SOAP.
 */
function btq_booking_soap_query_status($hotelCode, $dateRangeStart, $dateRangeEnd, $typeQuery = 'rooms', $rooms = 1, $adults = 1, $childrens = 0, $availRatesOnly = 'true'){
	require_once('lib/nusoap.php');
	
	$soap = btq_booking_soap_query_string($hotelCode, $dateRangeStart, $dateRangeEnd, $typeQuery, $rooms, $adults, $childrens, $availRatesOnly);
	
	$client = new nusoap_client($soap['wsaTo']);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = FALSE;
	$result = $client->send($soap['envelope'], $soap['wsaTo'], '');
	
	return $result;
}

/**
 * Consulta en el catálogo de amenidades y devuelve el nombre de la imagen.
 *
 * @author Saúl Díaz
 * @param string $amenityCode Código de la amenidad.
 * @return string Nombre del archivo de la amenidad. 
 */
function btq_booking_amenity_icon_name($amenityCode) {
	$amenitiesJSON_file = plugin_dir_path( __FILE__ ) . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'btq-amenities.json';
	$amenitiesJSON = file_get_contents($amenitiesJSON_file);
	$amenitiesArray = json_decode($amenitiesJSON, true);
	
	// Debug Log
	//btq_booking_log('amenities', $amenitiesArray);
	
	if (!isset($amenitiesArray[$amenityCode]))
		return FALSE;
	
	return $amenitiesArray[$amenityCode];
}

/**
 * Para depurar la consulta de los paquetes.
 *
 * @author Saúl Díaz
 * @param string $hotelCode Código de hotel en TravelClick
 * @return string Información retornada de la consulta.
 */
function btq_booking_admin_packages($hotelCode) {
	$response = btq_booking_soap_query($hotelCode, btq_booking_grid_date_start(), btq_booking_grid_date_end(btq_booking_grid_date_start()), 'packages');
	
	$ResponseRatePlan = $response['RoomStays']['RoomStay']['RatePlans']['RatePlan'];
		
	$arrayRatePlan = array();
	foreach($ResponseRatePlan as $RatePlanElement){
		if ($RatePlanElement['!RatePlanType'] == 'Package'){
			$arrayRatePlan[] = $RatePlanElement;
		}
	}
	?>
	<table class="wp-list-table widefat fixed striped" cellspacing="0">
		<thead>
			<tr>
				<th scope="col"><?php _e('Rate Plan Code','btq-booking'); ?></th>
				<th scope="col"><?php _e('Rate Plan Name','btq-booking'); ?></th>
				<th scope="col"><?php _e('Folder With Pictures','btq-booking'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($arrayRatePlan as $elementRatePlan){			
			$RatePlanCode = $elementRatePlan['!RatePlanCode'];
			//$roomRate = $arrayRoomRate[$RatePlanCode];
			//$roomTypeCode = $roomRate['!RoomTypeCode'];
			//$roomType = $arrayRoomType[$roomTypeCode];
			
			$images_packages_path   = 'assets/images/packages/';
			$images_dir = plugin_dir_path( __FILE__ ) . $images_packages_path . $RatePlanCode;
			$folder_with_pictures = (is_dir($images_dir)) ? __('Yes','btq-booking') : __('No','btq-booking');
			?>
			<tr>
				<td scope="col"><?php echo $RatePlanCode; ?></td>
				<td scope="col"><?php echo htmlentities($elementRatePlan['!RatePlanName']); ?></td>
				<td scope="col"><?php echo $folder_with_pictures; ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?php
}

/**
 * Genera la página para probar la carga de información de los paquetes.
 *
 * @author Saúl Díaz
 * @return void Genera la pagina de depuración.
 */
function btq_booking_admin_packages_page(){
?>
	<!-- wrap -->
	<div class="wrap">
		<h1><?php _e('Packages on TravelClick', 'btq-booking'); ?></h1>
		
		<div>
			<h2><?php _e('Spanish','btq-booking')?></h2>
			<?php btq_booking_admin_packages(esc_attr( get_option('btq_booking_tc_hotel_code_es') )); ?>
		</div>
		<div>
			<h2><?php _e('English','btq-booking')?></h2>
			<?php btq_booking_admin_packages(esc_attr( get_option('btq_booking_tc_hotel_code_us') )); ?>
		</div>
	</div>
	<!-- wrap -->
<?php
}

/**
 * Para depurar la consulta de las habitaciones.
 *
 * @author Saúl Díaz
 * @param string $hotelCode Código de hotel en TravelClick.
 * @return string Información retornada de la consulta.
 */
function btq_booking_admin_rooms($hotelCode) {
	$response = btq_booking_soap_query( $hotelCode, btq_booking_grid_date_start(), btq_booking_grid_date_end(btq_booking_grid_date_start()) );
	
	$RoomAmenities = array();
	$amenities = array();
	
	$RoomType = $response['RoomStays']['RoomStay']['RoomTypes']['RoomType'];
	
	?>
	<table class="wp-list-table widefat fixed striped" cellspacing="0">
		<thead>
			<tr>
				<th scope="col"><?php _e('Room Type Code','btq-booking'); ?></th>
				<th scope="col"><?php _e('Room Type Name','btq-booking'); ?></th>
				<th scope="col"><?php _e('Folder With Pictures','btq-booking'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($RoomType as $elementRoomType){
			$RoomAmenities[] = $elementRoomType['Amenities']['Amenity'];
			
			$images_rooms_path   = 'assets/images/rooms/';
			$images_dir = plugin_dir_path( __FILE__ ) . $images_rooms_path . $elementRoomType['!RoomTypeCode'];
			$folder_with_pictures = (is_dir($images_dir)) ? __('Yes','btq-booking') : __('No','btq-booking');
			
			?>
			<tr>
				<td scope="col"><?php echo $elementRoomType['!RoomTypeCode']; ?></td>
				<td scope="col"><?php echo htmlentities($elementRoomType['!RoomTypeName']); ?></td>
				<td scope="col"><?php echo $folder_with_pictures; ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	
	<hr>
	
	<?php
	
	for ($i = 0; $i < count($RoomAmenities); $i++){
		foreach($RoomAmenities[$i] as $RoomAmenitie){
			if (!isset($amenities[$RoomAmenitie['!ExistsCode']])){
				$amenities[$RoomAmenitie['!ExistsCode']] = $RoomAmenitie['!RoomAmenity'];
			}
		}
	}
	
	//$amenitiesUnique = array_unique($amenities);
	
	?>
	<table class="wp-list-table widefat fixed striped" cellspacing="0">
		<thead>
			<tr>
				<th scope="col"><?php _e('Amenity Code', 'btq-booking'); ?></th>
				<th scope="col"><?php _e('Amenity Name', 'btq-booking'); ?></th>
				<th scope="col"><?php _e('Amenity Icon', 'btq-booking'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$images_amenity_path = 'assets/images/amenity/';
		
		foreach($amenities as $amenitieCode => $amenitieName){
			$amenitieFileName = btq_booking_amenity_icon_name($amenitieCode);
			if (!empty($amenitieFileName)) {
				$image_icono_url = plugins_url( $images_amenity_path . $amenitieFileName, __FILE__ );
				$amenityIcon = '<img src="' . $image_icono_url . '" alt="' . htmlentities($amenitieName) . '" title="' . htmlentities($amenitieName) . '">';
			}
			else {
				$amenityIcon = 'No';
			}
			?>
			<tr>
				<td scope="col"><?php echo $amenitieCode; ?></td>
				<td scope="col"><?php echo htmlentities($amenitieName); ?></td>
				<td scope="col"><?php echo $amenityIcon; ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?php
}

/**
 * Genera la página para probar la carga de información del booking.
 *
 * @author Saúl Díaz
 * @return void Genera la pagina de depuración.
 */
function btq_booking_admin_rooms_page() {
?>
	<div class="wrap">
		<h1><?php _e('Rooms on TravelClick', 'btq-booking'); ?></h1>
		
		<div>
			<h2><?php _e('Spanish','btq-booking')?></h2>
			<?php btq_booking_admin_rooms(esc_attr( get_option('btq_booking_tc_hotel_code_es') )); ?>
		</div>
		<div>
			<h2><?php _e('English','btq-booking')?></h2>
			<?php btq_booking_admin_rooms(esc_attr( get_option('btq_booking_tc_hotel_code_us') )); ?>
		</div>
	</div><!-- wrap -->
<?php
}

/**
 * Cuando el plugin sea desactibado eliminara el Hook de la tarea programada.
 *
 * La tarea programada que se ejecuta para generar el archivo JSON con las fechas
 * no disponibles.
 *
 * @author Saúl Díaz
 * @return void
 */
function btq_booking_generate_unavailable_dates_deactivation() {
	wp_clear_scheduled_hook('btq_booking_generate_unavailable_dates_event');
}
register_deactivation_hook(__FILE__, 'btq_booking_generate_unavailable_dates_deactivation');

/**
 * Declara el Hook para generar las fechas no disponibles.
 *
 * El Hook es necesario para declarar la tarea que se ejecutara cada hora,
 * está tarea genera un archivo JSON con un arreglo de las fechas de los
 * días donde no tienen disponibilidad.
 *
 * @author Saúl Díaz
 * @return void 
 */
function btq_booking_generate_unavailable_dates_activation() {
    if (! wp_next_scheduled ( 'btq_booking_generate_unavailable_dates_event' )) {
		wp_schedule_event(time(), 'hourly', 'btq_booking_generate_unavailable_dates_event');
    }
}
register_activation_hook(__FILE__, 'btq_booking_generate_unavailable_dates_activation');

/**
 * Genera el archivo JSON con el arreglo de fechas en donde no hay disponibilidad y devuelve elestado
 *
 * @author Saúl Díaz
 * @return mixed Archivo JSON y tabala
 */
function btq_booking_generate_unavailable_dates_status(){
	$dateRangeStart = date('Y-m-d');
	$dateRangeEnd   = date('Y-m-d', strtotime($dateRangeStart . ' + 1 year'));
	$dates = btq_booking_grid_dates($dateRangeStart, $dateRangeEnd);
	$datesUnavailable = array();
	
	?>
	<table class="wp-list-table widefat fixed striped" cellspacing="0">
		<thead>
			<tr>
				<th scope="col"><?php _e('Date', 'btq-booking'); ?></th>
				<th scope="col"><?php _e('Available', 'btq-booking'); ?></th>
				<th scope="col"><?php _e('Description', 'btq-booking'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($dates as $date){
			$dayRangeStart = $date->format('Y-m-d');
			$dayRangeEnd   = date('Y-m-d', strtotime($date->format('Y-m-d') . ' + 1 day'));
			$result = btq_booking_soap_query_status(esc_attr(get_option('btq_booking_tc_hotel_code_es')), $dayRangeStart, $dayRangeEnd);
			if (isset($result['Errors'])){
				$errors = $result['Errors'];
				$description = 'Error Code: '. $errors['Error']['!Code'] .' - '. $errors['Error']['!ShortText'];
				$is_available = __('No','btq-booking');
				$datesUnavailable[] = $dayRangeStart;
			}
			else {
				$is_available = __('Yes','btq-booking');
				$description = '';
			}
			?>
			<tr>
				<td scope="col"><?php echo $dayRangeStart; ?></td>
				<td scope="col"><?php echo $is_available; ?></td>
				<td scope="col"><?php echo htmlentities($description); ?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?php
	
	$js_dir = plugin_dir_path( __FILE__ ) . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR ;
	file_put_contents( $js_dir . 'btq-unavailable.json', json_encode($datesUnavailable) );
}

/**
 * Genera el JSON de los días no disponibles.
 *
 * @author Saúl Díaz
 * @return void Genera la pagina de depuración.
 */
function btq_booking_admin_generate_unavailable_dates_page() {
?>
	<div class="wrap">
		<h1><?php _e('Generate Unavailable Dates TravelClick','btq-booking'); ?></h1>
		<?php btq_booking_generate_unavailable_dates_status(); ?>
	</div><!-- wrap -->
<?php
}

/**
 * Genera el archivo JSON con el arreglo de fechas en donde no hay disponibilidad.
 *
 * @author Saúl Díaz
 * @return file Archivo JSON
 */
function btq_booking_generate_unavailable_dates(){
	$dateRangeStart = date('Y-m-d');
	$dateRangeEnd   = date('Y-m-d', strtotime($dateRangeStart . ' + 1 year'));
	$dates = btq_booking_grid_dates($dateRangeStart, $dateRangeEnd);
	$datesUnavailable = array();
	
	foreach($dates as $date){
		$dayRangeStart = $date->format('Y-m-d');
		$dayRangeEnd   = date('Y-m-d', strtotime($date->format('Y-m-d') . ' + 1 day'));
		if (btq_booking_soap_query(esc_attr(get_option('btq_booking_tc_hotel_code_es')), $dayRangeStart, $dayRangeEnd) === FALSE){
			$datesUnavailable[] = $dayRangeStart;
		}
	}
	
	$js_dir = plugin_dir_path( __FILE__ ) . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR ;
	file_put_contents( $js_dir . 'btq-unavailable.json', json_encode($datesUnavailable) );
}
add_action('btq_booking_generate_unavailable_dates_event', 'btq_booking_generate_unavailable_dates');

/**
 * Genera la descripción con las estiquetas HTML necesarias para el link "Ver más".
 *
 * @author Saúl Díaz
 * @param string $description Descripción devuelta por TravelClick
 * @param string $language Código de idioma
 * @return string Descripción con etiquetas necesarias para el link "Ver más".
 */
function btq_booking_grid_split_description($description, $language = 'es'){
	if(!empty($description) && is_string($description)){
		
		$descriptionStripTags = strip_tags($description);
		$wordsArray = explode(' ', $descriptionStripTags);
		
		$wordsArrayFirst = Array();
		$wordsArrayLast  = Array();
		for($i = 0; $i < count($wordsArray); $i++){
			if ($i <= 30) {
				$wordsArrayFirst[] = $wordsArray[$i];
			}
			else {
				$wordsArrayLast[] = $wordsArray[$i];
			}
		}
		
		$textFirst = trim(implode(' ', $wordsArrayFirst));
		$textLast  = trim(implode(' ', $wordsArrayLast));
		
		?>
		<div>
			<?php echo $textFirst . ' '; ?> 
			<?php if(!empty($textLast)){ ?>
			<a class="vermas"><?php _e('View more', 'btq-booking'); ?></a>
			<span class="texto_recorrido" style="display:none"><?php echo $textLast; ?></span>
			<?php } ?>
		</div>
		<?php
	}
}

/**
 * Devuelve un arreglo con los nombres de las imagenes contenidas en un directorio.
 *
 * @author Saúl Díaz
 * @param string $path Ruta en disco del directorio con las imagenes.
 * @return array Lista de los nombres de archivo de las imagenes contenidas en la ruta.
 */
function btq_booking_grid_get_images($path) {
	$files = scandir($path);
	$images = array();
	
	foreach ($files as $file) {
		if (!is_dir($path . DIRECTORY_SEPARATOR . $file)){
			if (preg_match('/^.*\.(jpg|jpeg|png|gif)$/', $file) !== FALSE) array_push($images, $file);
		}
	}
	
	return $images;
}

/**
 * Grid del booking con los datos de habitaciones disponibles devueltos de la consulta a TravelClick.
 *
 * Genera en formato HTML con las etiquetas con clases CSS de Bootstrap el resultado
 * de la consulta a TraveClick.
 * 
 * @author Saúl Díaz
 * @author José del Carmen
 * @param string $language Código de idioma.
 * @param string $dateRangeStart Fecha del día de llegada.
 * @param string $dateRangeEnd Fecha del día de salida.
 * @param string $typeQuery Tipo de consulta: habitaciones o paquetes.
 * @param int $rooms Cantidad de habitaciones.
 * @param int $adults Cantidad de adultos.
 * @param int $childrens Cantidad de niños.
 * @param string $availRatesOnly Valor booleano 'true' o 'false' para
 *		la consulta de habitaciones disponibles.
 * @return string HTML del Grid de habitaciones.
 */
function btq_booking_grid_rooms($language = 'es', $dateRangeStart, $dateRangeEnd, $typeQuery = 'rooms', $rooms = 1, $adults = 1, $childrens = 0, $availRatesOnly = 'true'){
	
	switch($language){
		case 'es':
			$hotelCode    = esc_attr( get_option('btq_booking_tc_hotel_code_es') );
			$currency     = 'MXN';
			$themeid      = esc_attr( get_option('btq_booking_tc_hotel_themeid_es') );
		break;
		case 'en':
			$hotelCode    = esc_attr( get_option('btq_booking_tc_hotel_code_us') );
			$currency     = 'USD';
			$themeid      = esc_attr( get_option('btq_booking_tc_hotel_themeid_us') );
		break;
	}
	
	$response = btq_booking_soap_query($hotelCode, $dateRangeStart, $dateRangeEnd, $typeQuery, $rooms, $adults, $childrens, $availRatesOnly);
	
	//btq_booking_log('resultado', $response);
	
	if ($response !== FALSE) {
		// Debug Log
		//btq_booking_log('grid_rooms', $response);
		
		$RoomType = $response['RoomStays']['RoomStay']['RoomTypes']['RoomType'];
		
		$arrayRoomType = array();
		foreach($RoomType as $RoomTypeElement){
			$arrayRoomType[] = $RoomTypeElement;
		}
		
		
		$RoomRate = $response['RoomStays']['RoomStay']['RoomRates']['RoomRate'];
		
		$arrayRoomRate = array();
		foreach($RoomRate as $RoomRateElement){
			$arrayRoomRate[] = $RoomRateElement;
		}
		
		$images_rooms_path   = 'assets/images/rooms/';
		$images_amenity_path = 'assets/images/amenity/';
		$images_iconos_path = 'assets/images/iconos/';
		
		$i = 0;
		foreach($arrayRoomType as $elementRoomType){
			$roomTypeCode = $elementRoomType['!RoomTypeCode'];
			$images_dir = plugin_dir_path( __FILE__ ) . $images_rooms_path . $roomTypeCode;
			$images = btq_booking_grid_get_images($images_dir);
			?>
			
			<section class="row">
				
				<article class="col-md-5">
					<div id="btq-carousel-<?php echo $roomTypeCode; ?>" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
						<?php 
						$count_img = 0;
						foreach ($images as $im) {
						$class_active = ($count_img == 0) ? ' class="active"' : '';
						?>
							<li data-target="#btq-carousel-<?php echo $roomTypeCode; ?>" data-slide-to="<?php echo $count_img; ?>"<?php echo $class_active; ?>></li>
						<?php
						$count_img++;
						}
						?>
						</ol>
						
						<!-- Wrapper for slides -->
						<div class="carousel-inner">
						<?php
						$count_img = 1;
						foreach ($images as $image_name) {
						$image_url = plugins_url( $images_rooms_path . $roomTypeCode . DIRECTORY_SEPARATOR . $image_name, __FILE__ );
						$class_active = ($count_img == 1) ? ' active' : '';
						?> 
							<div class="item<?php echo $class_active?>">
								<img src="<?php echo $image_url; ?>" alt="Habitaciones">
							</div>
						<?php
						$count_img++;
						}
						?>
						</div>
	
						<!-- Left and right controls -->
						<a class="left carousel-control" href="#btq-carousel-<?php echo $roomTypeCode; ?>" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
							<span class="sr-only">Anterior</span>
						</a>
						<a class="right carousel-control" href="#btq-carousel-<?php echo $roomTypeCode; ?>" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
							<span class="sr-only">Siguiente</span>
						</a>
					</div>
				</article>
				
				<article class="col-md-4">
					<h3 class="titulo"><?php echo $elementRoomType['!RoomTypeName'] ?></h3>
					<?php btq_booking_grid_split_description($elementRoomType['RoomDescription']['Text']['!Text'], $language); ?>
					
					<?php
					foreach($elementRoomType['Amenities']['Amenity'] as $RoomAmenitie){
						if ( isset( $RoomAmenitie['!ExistsCode'] ) ){
							//$RoomAmenitie['!ExistsCode'], $RoomAmenitie['!RoomAmenity'];
							$amenityCode     = $RoomAmenitie['!ExistsCode'];
							$amenityFileName = btq_booking_amenity_icon_name($amenityCode);
							if (!empty($amenityFileName)) {
								$image_icono_url = plugins_url( $images_amenity_path . $amenityFileName, __FILE__ );
								?>
								<img class="iconoshabitacion" src="<?php echo $image_icono_url; ?>" alt="<?php echo htmlentities($RoomAmenitie['!RoomAmenity']); ?>" title="<?php echo htmlentities($RoomAmenitie['!RoomAmenity']); ?>" width="40" height="40">
								<?php
							}
							else {
								//error_log( 'ExistsCode: ' . $RoomAmenitie['!ExistsCode'] . ' - RoomAmenity: ' . $RoomAmenitie['!RoomAmenity'] );
								//btq_booking_log('amenitiesExistsCodeRooms', 'ExistsCode: ' . $RoomAmenitie['!ExistsCode'] . ' - RoomAmenity: ' . $RoomAmenitie['!RoomAmenity'], true);
							} 
						}
					}
					?>
								
					<hr class="linealetras" />
					<img src="<?php echo plugins_url( $images_iconos_path . 'icon_like.png', __FILE__ ); ?>" alt="Like" width="25" height="25">
					<img src="<?php echo plugins_url( $images_iconos_path . 'icon_heart_uns.png', __FILE__ ); ?>" alt="Heart" width="25" height="25">
				</article>
				
				<article class="col-md-3 grisfondo">
					<form>
						
						<hr class="linea"/>
						
					<?php
					$rate_room = array();
					for ($j = 0; $j < count($arrayRoomRate); $j++) {
						if(isset($arrayRoomRate[$j]['!RoomTypeCode'])) {
							if($arrayRoomRate[$j]['!RoomTypeCode'] == $roomTypeCode) array_push($rate_room, $arrayRoomRate[$j]);
						}
					}
											
					for ($l = 0; $l < count($rate_room); $l++) {
						$amount_total    = number_format_i18n( (($language == 'es')?($rate_room[$l]['Total']['!AmountAfterTax'] + $rate_room[$l]['Total']['!Discount']):$rate_room[$l]['Total']['!GrossAmountBeforeTax']), 2 );
						$amount_discount = number_format_i18n( (($language == 'es')?$rate_room[$l]['Total']['!AmountAfterTax']:$rate_room[$l]['Total']['!AmountBeforeTax']), 2 );
						?>
						<label class="radio-inline">
							<input type="radio" name="optradio"><?php echo $rate_room[$l]['!RatePlanName']; ?><br>
							<span>$<?php echo $amount_total . ' ' . $currency; ?></span><br>
							$<?php echo $amount_discount . ' ' . $currency; ?>
						</label>
						<hr class="linea"/>
						<?php
						if ($precio == 0) { 
							/* Inicializa el valor de precio*/
							$precio = (($language == 'es')?$rate_room[$l]['Total']['!AmountAfterTax']:$rate_room[$l]['Total']['!AmountBeforeTax']);
						} 
						else {
							if ($precio > $rate_room[$l]['Total']['!AmountAfterTax']){ /* Valida que sea el precio menor*/
								$precio = $rate_room[$l]['Total']['!AmountAfterTax'];
							}
						}
					}
					
					$precio =  number_format_i18n($precio, 2);
					?>
					</form>
					
					<h3 align="center">$<?php echo $precio . ' ' . $currency; ?>/noche</h3>
					<hr class="linea"/>
					
					<button type="button" class="btn btq-btn" onclick="window.open('https://reservations.travelclick.com/<?php echo $hotelCode ?>?themeid=<?php echo $themeid ?>&amp;datein=<?php echo date_format(date_create($dateRangeStart), "m/d/Y");?>&amp;dateout=<?php echo date_format(date_create($dateRangeEnd), "m/d/Y");?>&amp;roomtypeid=<?php echo $roomTypeCode; ?>&amp;adults=<?php echo $adults; ?>&amp;children=<?php echo $childrens; ?>&amp;rooms=<?php echo $rooms ?>&amp;currency=<?php echo $currency?>#/accommodation/room','_blank');"><?php _e('Book Now', 'btq-booking'); ?></button>
				</article>
				
			</section>
			
			<hr class="lineaabajo" />
			<?php
			$i++;
			$precio = 0;
		} // foreach($arrayRoomType as $elementRoomType)
	} // if ($response !== FALSE)
} // function btq_booking_grid_rooms()

/**
 * Grid del booking con los datos de paquetes disponibles devueltos de la consulta a TravelClick.
 *
 * Genera en formato HTML con las etiquetas con clases CSS de Bootstrap el resultado
 * de la consulta a TraveClick.
 * 
 * @author Saúl Díaz
 * @author José del Carmen
 * @param string $language Código de idioma.
 * @param string $dateRangeStart Fecha del día de llegada.
 * @param string $dateRangeEnd Fecha del día de salida.
 * @param string $typeQuery Tipo de consulta: habitaciones o paquetes.
 * @param int $rooms Cantidad de habitaciones.
 * @param int $adults Cantidad de adultos.
 * @param int $childrens Cantidad de niños.
 * @param string $availRatesOnly Valor booleano 'true' o 'false' para
 *		la consulta de habitaciones disponibles.
 * @return string HTML del Grid de pauetes.
 */
function btq_booking_grid_packages($language = 'es', $dateRangeStart, $dateRangeEnd, $typeQuery = 'packages', $rooms = 1, $adults = 2, $childrens = 0, $availRatesOnly = 'true'){
	
	switch($language){
		case 'es':
			$hotelCode    = esc_attr( get_option('btq_booking_tc_hotel_code_es') );
			$currency     = 'MXN';
			$themeid      = esc_attr( get_option('btq_booking_tc_hotel_themeid_es') );
		break;
		case 'en':
			$hotelCode    = esc_attr( get_option('btq_booking_tc_hotel_code_us') );
			$currency     = 'USD';
			$themeid      = esc_attr( get_option('btq_booking_tc_hotel_themeid_us') );
		break;
	}
	
	$response = btq_booking_soap_query($hotelCode, $dateRangeStart, $dateRangeEnd, $typeQuery, $rooms, $adults, $childrens, $availRatesOnly);
	
	if ($response !== FALSE) {
		// Debug Log
		//btq_booking_log('grid_packages', $response);
		
		$ResponseRatePlan = $response['RoomStays']['RoomStay']['RatePlans']['RatePlan'];
		
		$arrayRatePlan = array();
		foreach($ResponseRatePlan as $RatePlanElement){
			if ($RatePlanElement['!RatePlanType'] == 'Package'){
				$arrayRatePlan[] = $RatePlanElement;
			}
		}
		
		// Debug Log
		//btq_booking_log('grid_packages_rate_plan', $arrayRatePlan);
		
		
		$ResponseRoomRate = $response['RoomStays']['RoomStay']['RoomRates']['RoomRate'];
		
		$arrayRoomRate = array();
		foreach($ResponseRoomRate as $RoomRateElement){
			if ($RoomRateElement['!RatePlanType'] == 'Package'){
				$arrayRoomRate[$RoomRateElement['!RatePlanCode']] = $RoomRateElement;
			}
		}
		
		// Debug Log
		//btq_booking_log('grid_packages_room_rate', $arrayRoomRate);
		
		$ResponseRoomType = $response['RoomStays']['RoomStay']['RoomTypes']['RoomType'];
		
		$arrayRoomTypeAll = array();
		foreach($ResponseRoomType as $RoomTypeElement){
			$arrayRoomTypeAll[$RoomTypeElement] = $RoomTypeElement;
		}
		
		$arrayRoomType = array();
		foreach($arrayRoomTypeAll as $arrayRoomTypeAllElement){
			foreach($arrayRoomRate as $arrayRoomRateElement){
				if($arrayRoomTypeAllElement['!RoomTypeCode'] == $arrayRoomRateElement['!RoomTypeCode']){
					$arrayRoomType[$arrayRoomTypeAllElement['!RoomTypeCode']] = $arrayRoomTypeAllElement;
				}
			}
		}
		
		// Debug Log
		//btq_booking_log('grid_packages_room_type', $arrayRoomType);
		
		
		$images_packages_path = 'assets/images/packages/';
		$images_amenity_path = 'assets/images/amenity/';
		$images_iconos_path = 'assets/images/iconos/';
		
		$i = 0;
		foreach($arrayRatePlan as $elementRatePlan){
			
			$RatePlanCode = $elementRatePlan['!RatePlanCode'];
			$roomRate = $arrayRoomRate[$RatePlanCode];
			$roomTypeCode = $roomRate['!RoomTypeCode'];
			$roomType = $arrayRoomType[$roomTypeCode];
			
			// Debug Log
			//btq_booking_log('grid_packages_for_room_rate', $roomRate);
			
			$images_dir = plugin_dir_path( __FILE__ ) . $images_packages_path . $RatePlanCode;
			$images = btq_booking_grid_get_images($images_dir);
			?>
			
			<section class="row">
				
				<article class="col-md-5">
					<div id="btq-carousel-<?php echo $RatePlanCode; ?>" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
						<?php 
						$count_img = 0;
						foreach ($images as $im) {
						$class_active = ($count_img == 0) ? ' class="active"' : '';
						?>
							<li data-target="#btq-carousel-<?php echo $RatePlanCode; ?>" data-slide-to="<?php echo $count_img; ?>"<?php echo $class_active; ?>></li>
						<?php
						$count_img++;
						}
						?>
						</ol>
						
						<!-- Wrapper for slides -->
						<div class="carousel-inner">
						<?php
						$count_img = 1;
						foreach ($images as $image_name) {
						$image_url = plugins_url( $images_packages_path . $RatePlanCode . DIRECTORY_SEPARATOR . $image_name, __FILE__ );
						$class_active = ($count_img == 1) ? ' active' : '';
						?> 
							<div class="item<?php echo $class_active?>">
								<img src="<?php echo $image_url; ?>" alt="Habitaciones">
							</div>
						<?php
						$count_img++;
						}
						?>
						</div>
	
						<!-- Left and right controls -->
						<a class="left carousel-control" href="#btq-carousel-<?php echo $RatePlanCode; ?>" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
							<span class="sr-only">Anterior</span>
						</a>
						<a class="right carousel-control" href="#btq-carousel-<?php echo $RatePlanCode; ?>" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
							<span class="sr-only">Siguiente</span>
						</a>
					</div>
				</article>
				
				<article class="col-md-4">
					<h3 class="titulo"><?php echo $elementRatePlan['!RatePlanName'] ?></h3>
					<?php btq_booking_grid_split_description($elementRatePlan['RatePlanDescription']['Text']['!Text'], $language); ?>
					
					<?php
					foreach($roomType['Amenities']['Amenity'] as $RoomAmenitie){
						if ( isset( $RoomAmenitie['!ExistsCode'] ) ){
							//$RoomAmenitie['!ExistsCode'], $RoomAmenitie['!RoomAmenity'];
							$amenityCode     = $RoomAmenitie['!ExistsCode'];
							$amenityFileName = btq_booking_amenity_icon_name($amenityCode);
							if (!empty($amenityFileName)) {
								$image_icono_url = plugins_url( $images_amenity_path . $amenityFileName, __FILE__ );
								?>
								<img class="iconoshabitacion" src="<?php echo $image_icono_url; ?>" alt="<?php echo htmlentities($RoomAmenitie['!RoomAmenity']); ?>" title="<?php echo htmlentities($RoomAmenitie['!RoomAmenity']); ?>" width="40" height="40">
								<?php
							}
							else {
								//error_log( 'ExistsCode: ' . $RoomAmenitie['!ExistsCode'] . ' - RoomAmenity: ' . $RoomAmenitie['!RoomAmenity'] );
								//btq_booking_log('amenitiesExistsCodePackages', 'ExistsCode: ' . $RoomAmenitie['!ExistsCode'] . ' - RoomAmenity: ' . $RoomAmenitie['!RoomAmenity'], true);
							} 
						}
					}
					?>
					<hr class="linealetras" />
					
					<img src="<?php echo plugins_url( $images_iconos_path . 'icon_like.png', __FILE__ ); ?>" alt="Like" width="25" height="25">
					<img src="<?php echo plugins_url( $images_iconos_path . 'icon_heart_uns.png', __FILE__ ); ?>" alt="Heart" width="25" height="25">
				</article>
				
				<article class="col-md-3 grisfondo">
					<form>
						<hr class="linea"/>
						<label class="radio-inline">
						  <?php $amount = number_format_i18n( (($language == 'es')?$roomRate['Total']['!AmountAfterTax']:$roomRate['Total']['!AmountBeforeTax']), 2 ); ?>
		                  <input type="radio" name="optradio"><?php echo $roomRate['!RoomTypeName']; ?><br>
		                  $<?php echo $amount . ' ' . $currency; ?>
		                </label>
		                <hr class="linea"/>
					</form>
	
					<?php
					/* Inicializa el valor de precio*/
					$precio = number_format_i18n( (($language == 'es')?$roomRate['Total']['!AmountAfterTax']:$roomRate['Total']['!AmountBeforeTax']), 2 );
					?>
					
					<h3 align="center">$<?php echo $precio . ' ' . $currency; ?>/noche</h3>
					<hr class="linea"/>
					
					<button type="button" class="btn btq-btn" onclick="window.open('https://reservations.travelclick.com/<?php echo $hotelCode ?>?themeid=<?php echo $themeid ?>&amp;datein=<?php echo date_format(date_create($dateRangeStart), "m/d/Y");?>&amp;dateout=<?php echo date_format(date_create($dateRangeEnd), "m/d/Y");?>&amp;roomtypeid=<?php echo $roomTypeCode; ?>&amp;packageid=<?php echo $RatePlanCode; ?>&amp;adults=<?php echo $adults; ?>&amp;children=<?php echo $children; ?>&amp;rooms=<?php echo $rooms ?>&amp;currency=<?php echo $currency?>#/accommodation/package','_blank');"><?php _e('Book Now', 'btq-booking'); ?></button>
				</article>
				
			</section>
			
			<hr class="lineaabajo" />
			<?php
			$i++;
			$precio = 0;
		} // foreach($arrayRoomType as $elementRatePlan)
	} // if ($response !== FALSE)
} // function btq_booking_grid_packages()

/**
 * Genera formulario de conulta a TravelClick
 *
 * @author Saúl Díaz
 * @author José del Carmen
 * @param string $language Código de idioma.
 * @return string Formulario de consulta.
 */
function btq_booking_grid_form($language = 'es') {	
	$iconos_dir = 'assets/images/iconos';
	?>
		<hr class="linea"/>	
		
		<section class="row">
			<article class="col-md-12">
				<h5 class="hosp"><?php _e('Select a PACKAGE or ROOM', 'btq-booking'); ?></h5>
			</article>
		</section>

		<hr class="linea" />

		<section class="row">
			<div class="col-xs-12 col-md-4">
				<button id="btq-btn-rooms" name="btq-btn-rooms" class="btn btn-default btq-btn"><?php _e('Rooms', 'btq-booking'); ?></button>
			</div>
			<div class="col-xs-12 col-md-4">
				<button id="btq-btn-packages" name="btq-btn-rooms" class="btn btq-btn"><?php _e('Packages', 'btq-booking'); ?></button>
			</div>
			<div class="col-xs-12 col-md-4">
				<button id="btq-btn-top" name="btq-btn-top" class="btn btq-btn"><?php _e('Top rated', 'btq-booking'); ?></button>
			</div>
		</section>
		
		<hr class="linea" />
		
		<section class="row">
			
			<form name="btq-booking-form" id="btq-booking-form" target="_self" method="post">
					
				<article class="col-xs-12 col-md-4">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<input type="text" autocomplete="off" class="btq-input" id="btq-date-start" name="btq-date-start" placeholder="<?php echo _e('Check-in', 'btq-booking'); ?>">
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<input type="text" autocomplete="off" class="btq-input" id="btq-date-end" name="btq-date-end" placeholder="<?php echo _e('Check-out', 'btq-booking'); ?>">
							</div>		
						</div>
					</div>
				</article>
				
				<article class="col-xs-12 col-md-4">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<select class="btq-select" id="btq-num-adults" name="btq-num-adults">
									<?php for ($i = 1; $i <= 9; $i ++) { ?>
										<option value="<?php echo $i; ?>"><?php printf( _n('An adult', '%s adults', $i, 'btq-booking'), number_format_i18n($i) ); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group">
								<select class="btq-select" id="btq-num-children" name="btq-num-children">
									<?php for ($i = 0; $i <= 9; $i ++) { ?>
										<?php if ($i == 0): ?>
											<option value="<?php echo $i; ?>"><?php _e('Without children', 'btq-booking'); ?></option>
										<?php else:?>
											<option value="<?php echo $i; ?>"><?php printf( _n('A child', '%s children', $i, 'btq-booking'), number_format_i18n($i) ); ?></option>
										<?php endif;?>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</article>
				
				<article class="col-xs-12 col-md-2">
					<div class="form-group">
						<select class="btq-select" id="btq-num-rooms" name="btq-num-rooms">
							<?php for ($i = 1; $i <= 9; $i ++) { ?>
								<option value="<?php echo $i; ?>"><?php printf( _n('A room', '%s rooms', $i, 'btq-booking'), number_format_i18n($i) ); ?></option>
							<?php } ?>
						</select>
					</div>
				</article>
				
				<article class="col-xs-12 col-md-2">	
					<input type="hidden" id="btq-type-query" name="btq-type-query" value="rooms">				
					<button class="btn btq-btn" name="btq-search" id="btq-search"><?php echo _e('Search', 'btq-booking') ; ?></button>
				</article>
			
			</form>
			
		</section>

		<hr class="linea"/>
		
		<section class="row">
			<article class="col-md-12">
				<p class="recordatorio"><?php echo _e('* Remember that having an advance reservation will always be a better option (rates shown at 90 days).', 'btq-booking'); ?></p>
			</article>
			<hr class="linea"/>
		</section>
		
        <hr class="linea" />
	<?php
}

/**
 * Añade a WordPress los assets JS y CSS necesarios para el Grid.
 *
 * @author Saúl Díaz
 * @return void Integra CSS y JS al frond-end del sitio.
 */
function btq_booking_grid_scripts() {
    if (!is_admin()) {
	    wp_enqueue_style( 'btq-booking-grid', plugins_url( 'assets/css' . DIRECTORY_SEPARATOR . 'style.css', __FILE__ ), 'solaz-child-style','1.0.0');
	    wp_enqueue_script( 'moment', plugins_url( 'assets/js' . DIRECTORY_SEPARATOR . 'moment.min.js', __FILE__ ), array(), '2.21.0', true);
	    wp_enqueue_script( 'moment-timezone', plugins_url( 'assets/js' . DIRECTORY_SEPARATOR . 'moment-timezone.js', __FILE__ ), array('moment'), '0.5.17', true);
	    wp_enqueue_script( 'btq-booking-grid-js', plugins_url( 'assets/js' . DIRECTORY_SEPARATOR . 'btq-booking.js', __FILE__ ), array('moment','moment-timezone'), '1.0.0');
	}
}
add_action( 'wp_enqueue_scripts', 'btq_booking_grid_scripts', 1003 );

function btq_booking_head_scripts(){
	/** 
	 * CSS personalizado dentro de <head>
	 * Estilos del BTQ Booking TC Grid
	 *
	 * Datepicker
	 * 
	 * #cb6666  Rosado rojo
	 * #222     Negro
	 * #cbd08c  Amarillo limon
	 * #666     Gris
	 * #C69807  Dorado - Gran Hotel
	 * #fff     Balnco
	 *
	 *
	 *
	 * Grid
	 *
	 * #BDBDBD  Gris claro
	 * #666     Gris
	 * #C69807  Dorado - Gran Hotel
	 */
	if (!is_admin()) {
	    ?>
	    <style type="text/css">
		    .ui-datepicker-unselectable span.ui-state-default{
				background-color: #cb6666 !important;
				color: #222 !important;
			}
			
			.btq-unavailable-day a.ui-state-default{
				background-color: #cbd08c !important;
				color: #666 !important;
			}
			
			.btq-unavailable-day a.ui-state-default:hover{
				background-color: <?php echo esc_attr( get_option('btq_booking_color_principal') ); ?> !important;
				color: #fff !important;
			}
			
			.grisfondo{
				background-color:#BDBDBD;
			}
			
			.radio-inline span{
				color: #666;
			}
			.linealetras {
				border-color:<?php echo esc_attr( get_option('btq_booking_color_principal') ); ?> !important;
			}
	    </style>
		<?php
	}
}
add_action('wp_enqueue_scripts', 'btq_booking_head_scripts', 1002);

/**
 * Declara el Widget de BTQ Booking TC en VisualCompouser.
 *
 * @author Saúl Díaz
 * @return void Widget de BTQ Booking TC en VisualCompouser.
 */
function btq_booking_grid_VC() {
	vc_map(array(
		'name'     => __( 'BTQ Booking', 'btq-booking' ),
		'base'     => 'btq-booking-grid',
		'class'    => '',
		'category' => __( 'Content', 'btq-booking'),
		'icon'     => plugins_url( 'assets/images/iconos' . DIRECTORY_SEPARATOR . 'btqdesign-logo.png', __FILE__ )
	));
}
add_action( 'vc_before_init', 'btq_booking_grid_VC' );

/**
 * Función del shortcode que imprime el BTQ Booking TC en el frond-end.
 *
 * @author Saúl Díaz
 * @return string Imprime el BTQ Booking TC
 */
function btq_booking_grid_shortcode() {
	ob_start();
	?>
	<div class="container">
    <?php
	btq_booking_grid_form( btq_booking_grid_current_language_code() );
	?>
	<div id="btq-booking-grid">
		<?php
		btq_booking_grid_rooms(
			btq_booking_grid_current_language_code(),
			btq_booking_grid_date_start(),
			btq_booking_grid_date_end(btq_booking_grid_date_start())
		);
		?>
	</div>
	</div>
	<?php
	$out = ob_get_clean();
	
	return $out;
}
add_shortcode( 'btq-booking-grid', 'btq_booking_grid_shortcode' );

/**
 * Genera la respuesta AJAX del la consulta al booking de TravelClick.
 *
 * @author Saúl Díaz
 * @return string Resultado de la consulta al booking de TravelClick.
 */
function btq_booking_grid_ajax() {
	// Debug Log
	//btq_booking_log('ajax-post', $_POST);
	
	if (isset(
		$_POST['data'],
		$_POST['data']['btq_date_start'],
		$_POST['data']['btq_date_end'],
		$_POST['data']['btq_type_query'],
		$_POST['data']['btq_num_rooms'],
		$_POST['data']['btq_num_adults'],
		$_POST['data']['btq_num_children']
	)){
		$post_data = $_POST['data'];
		
		if ($post_data['btq_type_query'] == 'rooms'){
			btq_booking_grid_rooms(
				btq_booking_grid_current_language_code(), 
				$post_data['btq_date_start'],
				$post_data['btq_date_end'],
				$post_data['btq_type_query'],
				$post_data['btq_num_rooms'],
				$post_data['btq_num_adults'],
				$post_data['btq_num_children']
			);
		}
		elseif ($post_data['btq_type_query'] == 'packages'){
			btq_booking_grid_packages(
				btq_booking_grid_current_language_code(), 
				$post_data['btq_date_start'],
				$post_data['btq_date_end'],
				$post_data['btq_type_query'],
				$post_data['btq_num_rooms'],
				$post_data['btq_num_adults'],
				$post_data['btq_num_children']
			);
		}
		else {
			echo '';
		}
	}
	else {
		echo '';
	}
}
add_action( 'wp_ajax_btq_booking_grid', 'btq_booking_grid_ajax' );
add_action( 'wp_ajax_nopriv_btq_booking_grid', 'btq_booking_grid_ajax' );

/**
 * Genera la respuesta AJAX del la consulta predeterminada de paquetes al booking de TravelClick.
 *
 * @author Saúl Díaz
 * @return string Resultado de la consulta de paquetes al booking de TravelClick.
 */
function btq_booking_grid_packages_ajax() {	
	if (isset($_POST['data']['btq_packages_init'])) {
		btq_booking_grid_packages(
			btq_booking_grid_current_language_code(),
			btq_booking_grid_date_start(),
			btq_booking_grid_date_end(btq_booking_grid_date_start())
		);
	}
	else {
		echo '';
	}
	wp_die();
}
add_action( 'wp_ajax_btq_booking_grid_packages', 'btq_booking_grid_packages_ajax' );
add_action( 'wp_ajax_nopriv_btq_booking_grid_packages', 'btq_booking_grid_packages_ajax' );

/**
 * Genera la respuesta AJAX del la consulta predeterminada de habitaciones al booking de TravelClick.
 *
 * @author Saúl Díaz
 * @return string Resultado de la consulta de habitaciones al booking de TravelClick.
 */
function btq_booking_grid_rooms_ajax() {	
	if (isset($_POST['data']['btq_rooms_init'])) {
		btq_booking_grid_rooms(
			btq_booking_grid_current_language_code(),
			btq_booking_grid_date_start(),
			btq_booking_grid_date_end(btq_booking_grid_date_start())
		);
	}
	else {
		echo '';
	}
	wp_die();
}
add_action( 'wp_ajax_btq_booking_grid_rooms', 'btq_booking_grid_rooms_ajax' );
add_action( 'wp_ajax_nopriv_btq_booking_grid_rooms', 'btq_booking_grid_rooms_ajax' );

/**
 * Devuelve la fecha de llegada disponible a 90 días o más.
 *
 * @autor Saúl Díaz
 * @return string Fecha de llegada disponible a 90 días o más.
 */
function btq_booking_grid_date_start() {
	$unavailableJSON_file = plugin_dir_path( __FILE__ ) . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'btq-unavailable.json';
	if (file_exists($unavailableJSON_file)) {
		$unavailableJSON = file_get_contents($unavailableJSON_file);
		$unavailableDatesArray = json_decode($unavailableJSON);
		for($days = 90; $days < 120; $days++){
			$date_start = date('Y-m-d', ( time() + (60*60*24*$days) ));
			if (array_search($date_start, $unavailableDatesArray) === FALSE){
				return $date_start;
			}
		}
	}
	else{
		return date('Y-m-d', ( time() + (60*60*24*90) ));
	}
}

/**
 * Devuelve la fecha de salida al día siguiente.
 *
 * @author Saúl Díaz
 * @param string $date_start Fecha de llegada.
 * @return string Fecha de salida.
 */
function btq_booking_grid_date_end($date_start) {
	return date('Y-m-d', strtotime($date_start . ' + 1 day'));
}

/**
 * Devuelve el código de idioma que se está utilizando.
 *
 * @author Saúl Díaz
 * @return string Código de idioma que se está utilizando.
 */
function btq_booking_grid_current_language_code() {

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
	
	//Debug
	//btq_booking_log('languages', $language, TRUE);
	
	return $language;
}
