<?php
	require_once('../../../wp-load.php');
	
	$js_dir = 'assets/js';
	$css_dir = 'assets/css';
	$datepicker_js_dir = 'assets/datepicker/js';
	$datepicker_css_dir = 'assets/datepicker/css';
	$images_dir = 'assets/images/habitacion';
	$iconos_dir = 'assets/images/iconos';
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hotel</title>

		
	<script src="<?php echo plugins_url( $js_dir . DIRECTORY_SEPARATOR . 'jquery.js', __FILE__ ); ?>"></script>
	<script src="<?php echo plugins_url( $js_dir . DIRECTORY_SEPARATOR . 'bootstrap.min.js', __FILE__ ); ?>"></script>
	<script src="<?php echo plugins_url( $js_dir . DIRECTORY_SEPARATOR . 'app.js', __FILE__ ); ?>"></script>
	<script src="<?php echo plugins_url( $datepicker_js_dir . DIRECTORY_SEPARATOR . 'bootstrap-datepicker.min.js', __FILE__ ); ?>" charset="utf-8"></script>
	<script src="<?php echo plugins_url( $js_dir . DIRECTORY_SEPARATOR . 'jquery-migrate-1.2.1.min.js', __FILE__ ); ?>"></script>

	<link rel="stylesheet" href="<?php echo plugins_url( $css_dir . DIRECTORY_SEPARATOR . 'bootstrap.min.css', __FILE__ ); ?>">
	<link rel="stylesheet" href="<?php echo plugins_url( $datepicker_css_dir . DIRECTORY_SEPARATOR . 'bootstrap-datepicker.css', __FILE__ ); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo plugins_url( $css_dir . DIRECTORY_SEPARATOR . 'estilos.css', __FILE__ ); ?>">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>

				

<body>

	<br><br><br>

	<div class="container">
		
		<hr class="linea"/>	
		
		<section class="row">
			<article class="col-md-5">
				<h5>Selecciona un PAQUETE o HABITACIÓN</h5>
			</article>
			<article class="col-md-7">&nbsp;</article>
		</section>

		<hr class="linea" />

		<section class="row">
			<article class="col-md-5">
				<button class="button col-xs-12 col-md-4" style="background-color:#C9B891">Habitaciones</button>
				<div class="clearfix visible-xs-block"></div>
				<button class="button col-xs-12 col-md-3" style="background-color:#C9B891">Paquetes</button>
				<div class="clearfix visible-xs-block"></div>
				<button class="button col-xs-12 col-md-5" style="background-color:#C9B891"><img src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_like.png', __FILE__ ); ?>" width="22" height="19" id="element1">&nbsp;&nbsp;Mejor Calificadas</button>
				<div class="clearfix visible-xs-block"></div>
			</article>
			
			<article class="col-md-4">
				<input class="buttonpick col-xs-6" id="entrada" placeholder="Fecha de entrada">
				<input class="buttonpickk col-xs-6" id="salida" placeholder="Fecha de salida">			
				<div class="clearfix visible-xs-block"></div>	
			</article>
			
			<article class="col-md-1">
				<select class="buttonpick2 col-xs-6">
					<option value="1">1 Adulto</option>
					<option value="2">2 Adultos</option>
					<option value="3">3 Adultos</option>
					<option value="4">4 Adultos</option>
					<option value="5">5 Adultos</option>
					<option value="6">6 Adultos</option>
					<option value="7">7 Adultos</option>
					<option value="8">8 Adultos</option>
					<option value="9">9 Adultos</option>
				</select>
				
				<select class="buttonpick2 col-xs-6">				
					<option value="0">0 Niños</option>
					<option value="1">1 Niño</option>
					<option value="2">2 Niños</option>
					<option value="3">3 Niños</option>
					<option value="4">4 Niños</option>
					<option value="5">5 Niños</option>
					<option value="6">6 Niños</option>
					<option value="7">7 Niños</option>
					<option value="8">8 Niños</option>
					<option value="9">9 Niños</option>
				</select>
			</article>
			
			<article class="col-md-2">					
				<button class="buttonbus col-xs-12">BUSCAR</button>
			</article>
		</section>

		<hr class="linea"/>

		<section class="row">
			<article class="col-md-5">
				<img src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_calendar2.png', __FILE__ ); ?>" width="30" height="30" id="element2">
				<h5 class="hosp">&nbsp;&nbsp;&nbsp;Consulta tus fechas-tarifa para hospedarte</h5>
			</article>

			<article class="col-md-7">
				<p class="recordatorio">*Recuerda que tener una reservación anticipada siempre será una mejor opción (tarifas mostradas a 90 días)</p>
			</article>
			<hr class="linea"/>
		</section>
		
		
		<!-- OK -->
		<section class="row">
			
			
			<article class="col-md-5">
				<div id="btq-carousel-00000" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#btq-carousel-00000" data-slide-to="0" class="active"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="1"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="2"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="2"></li>
					</ol>
		
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla1.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla2.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla3.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla4.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
					</div>
					
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#btq-carousel-00000" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="right carousel-control" href="#btq-carousel-00000" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
						<span class="sr-only">Siguiente</span>
					</a>
				</div>
			</article>
		
			<article class="col-md-4">

				<h3 class="titulo">Habitacion de Lujo King No Reembolsable</h3>

				<aside>La habitación de Lujo King No Reembolsable cuenta con una cama King size y vista a la calle 16 de septiembre. Televisor LCD de 50 pulgadas con control remoto y canales de cable, aire acondicionado, 
				<a href="#" id="vermas">Ver más</a>

				<aside id="mostrar" style="display:none">mini bar, sala de bano privada con regadera y bañera, espejo de vanidad, amenidades, secadora de cabello, cafetera y kit de cafe, closet, caja de seguridad, plancha y mesa de planchado, escritorio de trabajo, conexion wi-fi y alambrica a internet, llave electronica y telefono con linea directa. PREPAGO: SE LE COBRARÁ UN PREPAGO DEL PRECIO TOTAL EN CUALQUIER MOMENTO, CANCELACIÓN: SE LE COBRARÁ EL PRECIO TOTAL SI CANCELA SU RESERVA O SI ES NO SHOW</aside></aside> 
				
				
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-04.png', __FILE__ ); ?>" alt="icono">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-03.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-01.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-05.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<hr class="linealetras" style="border-color:#C9B891;" style="border:2px;" />
				<input type="image" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_like.png', __FILE__ ); ?>" alt="Submit" width="30" height="30">
				<input type="image" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_c.png', __FILE__ ); ?>" alt="Submit" width="30" height="30">
			</article>
		
			<article class="col-md-3">
				<br>
				<input type="checkbox"> Mejor tarifa garantizada <p>$MXN 2,733.03</p>
				<p>Con mas beneficios</p>
				<hr class="linea"/>
				<h3 align="center">$MXN 2,733.03   /noche</h3>
				<button class="buttonreserv">Reservar Ahora  </button>
			</article>
		</section>


		<!-- OK -->
		<section class="row">
			
			
			<article class="col-md-5">
				<div id="btq-carousel-00000" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#btq-carousel-00000" data-slide-to="0" class="active"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="1"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="2"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="2"></li>
					</ol>
		
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla1.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla2.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla3.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla4.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
					</div>
					
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#btq-carousel-00000" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="right carousel-control" href="#btq-carousel-00000" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
						<span class="sr-only">Siguiente</span>
					</a>
				</div>
			</article>
		
			<article class="col-md-4">

				<h3 class="titulo">Habitacion de Lujo King No Reembolsable</h3>

				<aside>La habitación de Lujo King No Reembolsable cuenta con una cama King size y vista a la calle 16 de septiembre. Televisor LCD de 50 pulgadas con control remoto y canales de cable, aire acondicionado, 
				<a href="#1" id="vermas1">Ver más</a>

				<aside id="mostrar1" style="display:none">mini bar, sala de bano privada con regadera y bañera, espejo de vanidad, amenidades, secadora de cabello, cafetera y kit de cafe, closet, caja de seguridad, plancha y mesa de planchado, escritorio de trabajo, conexion wi-fi y alambrica a internet, llave electronica y telefono con linea directa. PREPAGO: SE LE COBRARÁ UN PREPAGO DEL PRECIO TOTAL EN CUALQUIER MOMENTO, CANCELACIÓN: SE LE COBRARÁ EL PRECIO TOTAL SI CANCELA SU RESERVA O SI ES NO SHOW</aside></aside> 
				
				
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-04.png', __FILE__ ); ?>" alt="icono">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-03.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-01.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-05.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<hr class="linealetras" style="border-color:#C9B891;" style="border:2px;" />
				<input type="image" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_like.png', __FILE__ ); ?>" alt="Submit" width="30" height="30">
				<input type="image" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_c.png', __FILE__ ); ?>" alt="Submit" width="30" height="30">
			</article>
		
			<article class="col-md-3">
				<br>
				<input type="checkbox"> Mejor tarifa garantizada <p>$MXN 2,733.03</p>
				<p>Con mas beneficios</p>
				<hr class="linea"/>
				<h3 align="center">$MXN 2,733.03   /noche</h3>
				<button class="buttonreserv">Reservar Ahora  </button>
			</article>
		</section>


		<!-- OK -->
		<section class="row">
			
			
			<article class="col-md-5">
				<div id="btq-carousel-00000" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#btq-carousel-00000" data-slide-to="0" class="active"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="1"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="2"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="2"></li>
					</ol>
		
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla1.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla2.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla3.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla4.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
					</div>
					
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#btq-carousel-00000" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="right carousel-control" href="#btq-carousel-00000" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
						<span class="sr-only">Siguiente</span>
					</a>
				</div>
			</article>
		
			<article class="col-md-4">
				
				<h3 class="titulo">Habitacion de Lujo King No Reembolsable</h3>

				<aside>La habitación de Lujo King No Reembolsable cuenta con una cama King size y vista a la calle 16 de septiembre. Televisor LCD de 50 pulgadas con control remoto y canales de cable, aire acondicionado, 
				<a href="#2" id="vermas2">Ver más</a>

				<aside id="mostrar2" style="display:none">mini bar, sala de bano privada con regadera y bañera, espejo de vanidad, amenidades, secadora de cabello, cafetera y kit de cafe, closet, caja de seguridad, plancha y mesa de planchado, escritorio de trabajo, conexion wi-fi y alambrica a internet, llave electronica y telefono con linea directa. PREPAGO: SE LE COBRARÁ UN PREPAGO DEL PRECIO TOTAL EN CUALQUIER MOMENTO, CANCELACIÓN: SE LE COBRARÁ EL PRECIO TOTAL SI CANCELA SU RESERVA O SI ES NO SHOW</aside></aside> 
				
				
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-04.png', __FILE__ ); ?>" alt="icono">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-03.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-01.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-05.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<hr class="linealetras" style="border-color:#C9B891;" style="border:2px;" />
				<input type="image" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_like.png', __FILE__ ); ?>" alt="Submit" width="30" height="30">
				<input type="image" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_c.png', __FILE__ ); ?>" alt="Submit" width="30" height="30">
			</article>
		
			<article class="col-md-3">
				<br>
				<input type="checkbox"> Mejor tarifa garantizada <p>$MXN 2,733.03</p>
				<p>Con mas beneficios</p>
				<hr class="linea"/>
				<h3 align="center">$MXN 2,733.03   /noche</h3>
				<button class="buttonreserv">Reservar Ahora  </button>
			</article>
		</section>


		<!-- OK -->
		<section class="row">
			
			
			<article class="col-md-5">
				<div id="btq-carousel-00000" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#btq-carousel-00000" data-slide-to="0" class="active"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="1"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="2"></li>
						<li data-target="#btq-carousel-00000" data-slide-to="2"></li>
					</ol>
		
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla1.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla2.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla3.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
						<div class="item">
							<img src="<?php echo plugins_url( $images_dir . DIRECTORY_SEPARATOR . 'sencilla4.png', __FILE__ ); ?>" alt="Habitaciones">
						</div>
					</div>
					
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#btq-carousel-00000" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="right carousel-control" href="#btq-carousel-00000" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
						<span class="sr-only">Siguiente</span>
					</a>
				</div>
			</article>
		
			<article class="col-md-4">

				<h3 class="titulo">Habitacion de Lujo King No Reembolsable</h3>

				<aside>La habitación de Lujo King No Reembolsable cuenta con una cama King size y vista a la calle 16 de septiembre. Televisor LCD de 50 pulgadas con control remoto y canales de cable, aire acondicionado, 
				<a href="#3" id="vermas3">Ver más</a>

				<aside id="mostrar3" style="display:none">mini bar, sala de bano privada con regadera y bañera, espejo de vanidad, amenidades, secadora de cabello, cafetera y kit de cafe, closet, caja de seguridad, plancha y mesa de planchado, escritorio de trabajo, conexion wi-fi y alambrica a internet, llave electronica y telefono con linea directa. PREPAGO: SE LE COBRARÁ UN PREPAGO DEL PRECIO TOTAL EN CUALQUIER MOMENTO, CANCELACIÓN: SE LE COBRARÁ EL PRECIO TOTAL SI CANCELA SU RESERVA O SI ES NO SHOW</aside></aside> 
				
				
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-04.png', __FILE__ ); ?>" alt="icono">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-03.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-01.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-05.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<img class="iconoshabitacion hidden-xs hidden-sm" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_icon-02.png', __FILE__ ); ?>" alt="icono" width="60" height="50">
				<hr class="linealetras" style="border-color:#C9B891;" style="border:2px;" />
				<input type="image" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_like.png', __FILE__ ); ?>" alt="Submit" width="30" height="30">
				<input type="image" src="<?php echo plugins_url( $iconos_dir . DIRECTORY_SEPARATOR . 'gh_c.png', __FILE__ ); ?>" alt="Submit" width="30" height="30">
			</article>
		
			<article class="col-md-3">
				<br>
				<input type="checkbox"> Mejor tarifa garantizada <p>$MXN 2,733.03</p>
				<p>Con mas beneficios</p>
				<hr class="linea"/>
				<h3 align="center">$MXN 2,733.03   /noche</h3>
				<button class="buttonreserv">Reservar Ahora  </button>
			</article>
		</section>
		
		<hr class="lineaabajo" />	
	</div>
</body>
</html>
