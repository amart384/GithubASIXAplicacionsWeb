<?php
/***************************************************
version 1.5
Copyright © Agost, 2024 Toni Martinez]. Tots els drets reservats.

Aquest programa està protegit per les lleis de drets d'autor i altres drets de propietat intel·lectual. 
Qualsevol ús, còpia, modificació o distribució d'aquest programa sense el consentiment exprés de l'autor 
està estrictament prohibit, excepte en els casos permesos per la llei o per la llicència d'ús.

Es concedeix la llicencia (by-nc-nd) a

DESCÀRREC DE RESPONSABILITAT:
Aquest programari es proporciona "tal qual", sense cap tipus de garantia, explícita o implícita, incloent, 
però no limitant-se a, les garanties de comercialització, idoneïtat per a un propòsit particular o no 
infracció. En cap cas, l'autor serà responsable de cap reclamació, dany o altra responsabilitat, ja sigui 
per una acció contractual, un greuge o qualsevol altra raó, que sorgeixi de, fora de o en connexió amb el 
programari o l'ús d'aquest.
****************************************************/

/***************************************************
Notes:

Per amagar el codi. Des del notepad

Editar | Operaciones de Limpieza
Fin de linea -> espacio
 
Plugins | JSTool
JSMin

****************************************************/
//Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//No cache
header("Content-Type: text/html; charset=UTF-8");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

session_start(); // Iniciar la sesión

// Verificar si la cookie de aceptación ya existe, si existeix les renova
if (isset($_COOKIE['baajgi_accept_cookies_privacy_terms']) && $_COOKIE['baajgi_accept_cookies_privacy_terms'] == 'true') {
    // Si las condiciones ya fueron aceptadas, redirigir a la página principal
	// Establecer la cookie con un tiempo de vida de 1 año
    setcookie('baajgi_accept_cookies_privacy_terms', 'true', time() + (60 * 60 * 24 * 365), "/");
    // Inicio de la sesion
	$_SESSION['baajgi_accept_cookies_privacy_terms'] = true;
}else{
	header("Location: index.php");
	exit();
}

if (!isset($_COOKIE['baajgi_trackingNumber'])) {	
	//https://hayageek.com/generate-unique-id-in-php/
	//$trackingNumber = uniqid('trackingnumber_', true);
	//UUIDv4
	$trackingNumber = generarUIDUnic();
	setcookie('baajgi_trackingNumber', $trackingNumber, time() + (60 * 60 * 24 * 365), "/");
	$_SESSION['trackingnumber']=$trackingNumber;
}else{
	$_SESSION['trackingnumber']=$_COOKIE['baajgi_trackingNumber'];
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {	
	if (isset($_REQUEST['idcodiqr']) && !empty($_REQUEST['idcodiqr'])) {	
		$_SESSION['idcodiqr']=$_REQUEST['idcodiqr'];
	}		
}

function generarUIDUnic() {
    // Genera un ID único basado en la marca de tiempo en microsegundos, con más entropía
    $uid = uniqid('trackingnumber_', true);    
    // Aplica un hash SHA-1 para hacerlo más difícil de predecir	
	//$uidUnico = sha1($uid . mt_rand());  
    $uidUnico = 'trackingnumber_'.sha1($uid . random_bytes(10));    
    return $uidUnico;
}


?>
<!--
Copyright © 2024 Toni Martinez]. Tots els drets reservats.

Aquest programa està protegit per les lleis de drets d'autor i altres drets de propietat intel·lectual. 
Qualsevol ús, còpia, modificació o distribució d'aquest programa sense el consentiment exprés de l'autor 
està estrictament prohibit, excepte en els casos permesos per la llei o per la llicència d'ús.

Es concedeix la llicencia (by-nc-sa) a l'Ajuntament de Girona.

ex. MIT, GPL,
Podeu consultar els termes complets de la llicència a [enllaç o ubicació de la llicència].

DESCÀRREC DE RESPONSABILITAT:
Aquest programari es proporciona "tal qual", sense cap tipus de garantia, explícita o implícita, incloent, 
però no limitant-se a, les garanties de comercialització, idoneïtat per a un propòsit particular o no 
infracció. En cap cas, l'autor serà responsable de cap reclamació, dany o altra responsabilitat, ja sigui 
per una acció contractual, un greuge o qualsevol altra raó, que sorgeixi de, fora de o en connexió amb el 
programari o l'ús d'aquest.
-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta name="author" content="Toni Martinez, copyright (c) Agost, 2024">
	<meta name="description" content="Bústia d'avisos">
	<meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- No cache -->
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	
    <title>Bústia d'avisos</title>
 
	<!-- Enllaç a les icones awesome 4 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
	<!-- bootstrap per les caixes d'informació -->
	<!--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">-->	 
	<link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"/>	 
	<!-- bootstrap -->
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
	<!-- bootstrap icons -->
	<link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Recaptcha -->
	<script src="https://www.google.com/recaptcha/api.js?hl=ca" async defer></script>
	<!-- own lib -->
	<script src="js/balib.js?v=202501011.14"></script>
	<link rel="stylesheet" href="css/bastyle.css?v=202501012.14">
	
	<!-- Estils per les dues llibreries -->
	<link rel="stylesheet" href="css/bamaps.css?v=1.15">
	
	<!-- Google Maps lib 	
	<script src="js/bamaps.js?v=1.20"></script> -->
	
	<!-- Open Maps -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script> 
	<script src="js/bamapsoem.js?v=1.19"></script>
    <script src="https://unpkg.com/leaflet-gesture-handling"></script>
	
	<!-- ballistaetiquetes -->
	<script src="js/ballistaetiquetes.js?v=20250109.14"></script>
	<link rel="stylesheet" href="css/ballistaetiquetes.css?v=20250109.14"> 
	<style>

	</style>
</head>
<body>

	<div class="container my-5">
		<div class="row">
            <div class="col-lg-8 col-sm-12 mx-auto">
			
				<h4 class="titolprincipal"><i class="bi bi-mailbox-flag mx-2 fs-1"></i> Bústia d'avisos</h4>
				
				
				<!--En el siguiento codigo, añade el la parte inferior de caja, con el id camera, un boton redondo, de color blanco, que indique la captura de la imagen. Añade un efecto al boton que al pulsar indique que se ha pulsado el boton. Añade una rutina de jascript al pulsar el boton
				<h3 id="status-message" class="alert alert-info">Obrint la càmera, si us plau esperi ...</h3>
				<div id="divcamera">
					<div class="dadesform">Fotografia el motiu de l'avís:</div>
					<video id="camera" autoplay playsinline width="100%"></video>
					<button class="capture-roundbutton" onclick="captureImage()">			
						<i class="bi bi-camera"></i>
					</button>
					<br/>
					<div id="divbuttonscaptureimage">						
						<button class="btn btn-lg btn-success" id="load-button" onclick="loadImage()">Imatge de la galeria del telèfon</button> <br/>
						
					</div>	
				</div>
				<div id="divimages">
					<div id="captured-image-container">
						<img id="captured-image" src="" alt="Foto capturada">
						<i class="delete-icon bi bi-trash" onclick="deleteCapturedImage()"></i> 
					</div>
					
					<div id="divbuttonscaptureimage-again">
						<button id="capture-button-again" class="btn btn-lg btn-success" onclick="ShowCaptureImageButtons()">Tornar Capturar/Carregar Foto</button> <br/>			
						
					</div>		
				</div>
				-->				
				
				<!--deprecated <div id="divimages">
					<div id="captured-image-container">
						<img id="captured-image" src="" alt="Foto capturada">
						<i class="delete-icon bi bi-trash" onclick="deleteLoadedImage()"></i> 
					</div>
					
					<div id="divbuttonscaptureimage-again">
						<button id="capture-button-again" class="btn btn-lg btn-success" onclick="loadImageFromDisk()"><i class="bi bi-camera fs-3"></i>  Tornar Capturar/Carregar Foto</button> <br/>			
						
					</div>		
				</div>-->
				
				<div class="row justify-content-center">
					<div class="col-12">
						<div class="card mb-4">
							<div class="card-header bg-primary text-white">
								<h5><i class="bi bi-camera fs-3" ></i> Fotografia l'avís</h5>
							</div>
							<!-- text-center justify-content-center -->
							<div class="card-body text-center">
								<div id="divimagecarregada" class="row justify-content-center d-none">
									<div class="col-10 justify-content-center">
										<i class="delete-icon bi bi-trash text-danger" onclick="deleteLoadedImage()"></i>							
										<img id="captured-image" class="img-fluid" src="" alt="Foto capturada"/>									
										<br/>
										<button type="button" class="btn btn-lg btn-success" onclick="loadImageFromDisk()"><i class="bi bi-camera fs-3"></i> Tornar a fer foto</button>
									</div>
								</div>
								
								<div id="divcarregaimages" class="row justify-content-center">
									<div class="col-6">									
											<img src="img/imateajudacamera.png" class="card-img" alt="Una ma soste el mobil amb el boto de camera">
											<div class="d-flex flex-column justify-content-end">
												<button type="button" class="capture-roundbutton" onclick="loadImageFromDisk()">		
														<i class="bi bi-camera"></i>
												</button>
											</div>
									</div>
								</div>
								
								
							</div>							
						</div>
					</div>
				</div>
				
				<div id="divform">				

					<!-- Formulari per enviar la imatge i etiquetes -->
					<form id="image-form" class="needs-validation" novalidate action="processform.php" method="POST" enctype="multipart/form-data">
												
					<input type="hidden" id="image-data" name="attachedimage1">
						
					<div class="card mb-4 dadesform">
							<div class="card-header  bg-primary text-white">
								<h5><i class="bi bi-chat-left-text fs-3" ></i> Dades de l'avís</h5>
							</div>

							<div class="card-body">	
								
								<div class="row mb-3">						
									<div class="col-10 col-sm-10">
										<label class="col-form-label" for="localitzaciogps">Recollir la localització GPS</label>
									</div>
									<div class="col-2 col-sm-2">
										<input type="radio"  class="form-check-input form-control checkbox-large" id="localitzaciogps" name="tipuslocalitzacio" value="gps" onclick="getLocation('gps')" required>								
									</div>
								</div>
								
								<div class="row mb-3">						
									<div class="col-10 col-sm-10">
										<label class="col-form-label" for="localitzaciomapa">Marcar un punt en el mapa</label>
									</div>
									<div class="col-2 col-sm-2">
										<input type="radio"  class="form-check-input form-control checkbox-large" id="localitzaciomapa" name="tipuslocalitzacio" value="marcador" onclick="getLocation('marcador')" required default>								
									</div>
								</div>
								
								<div class="row mb-3">
									<div class="col-12 col-sm-12">
										<div id="map"></div>
										<span id="notapeumapa">(Utilitzar els dos dits per ampliar/moure el mapa)<span>
									</div>
									<div class="col-12 col-sm-12">
											<label class="col-form-label" for="adrecaavis">Adreça:<span class="text-danger">*</span></label>
											<input type="text" id="adrecaavis" class="form-control" name="adrecaavis" placeholder="Marca un punt sobre el mapa" pattern="[A-Za-zÀ-ÿ0-9 '-]{2,60}" required autocomplete="off">
										</div>	
								</div>
								
								
								<!-- Camps ocults per guardar latitud y longitud -->
								<input type="hidden" id="latitud" name="latitud">
								<input type="hidden" id="longitud" name="longitud">						
								<input type="hidden" id="cprt_API_KEY" name="cprt_API_KEY" value="c89b588b918303304c008b752306789854cd5ee27f307da525620855becb364b">	
						
								
								<div class="row mb-3">
									<div class="col-12 col-sm-12">
										<label class="col-form-label">Clica a l'etiqueta:<span class="text-danger">*</span></label>
											<div class="navbar-nav" id="menuContainer">
											  <!-- El menú s'emplenarà dinàmicament -->
											</div>
										</nav>	

										<!-- To delete The required attribute is not permitted on inputs with the readonly attribute specified 
										<input type="text" id="etiquetaavis" class="form-control"  name="etiquetaavis" required pattern="[A-Za-zÀ-ÿ '-]{2,200}" autocomplete="false"/>	-->
										<input type="hidden" id="etiquetaavis" class="form-control"  name="etiquetaavis"  autocomplete="false"/>
										
										<div class="form-group descripciooculta" id="textAreaGroup">
											<label for="descripcio">Descriu l'avís:</label>
											<textarea id="descripcio" class="form-control" name="descripcio"  rows="5" placeholder="Escriu una descripció..."></textarea>
										</div>
									</div>
								</div>

								
							</div>					
						</div>	
						
						<input type="hidden" id="selected-tags" name="tags">
								
						<div class="card mb-4 dadesform">
							<div class="card-header bg-primary text-white">
								<h5><i class="bi bi-person-vcard fs-3"></i> Informació de contacte</h5>
							</div>
							
							<div class="card-body">
							   
							   <div class="row mb-3 align-items-center">
									<div class="col-12 col-sm-12">
										<label class="col-form-label" for="respostaavis">Voleu rebre un seguiment?<span class="text-danger">*</span></label>
									</div>
									<div class="col-12 col-sm-12">
										<select class="form-control form-control-lg" id="respostaavis" name="respostaavis" required>
											<option value="" disabled selected>Selecciona una opció</option>
											<option value="SI">Sí</option>
											<option value="NO">No</option>
										</select>
										<div class="invalid-feedback">
											Si us plau selecciona una opció.
										</div>
									</div>
								</div>
								
								<div class="row mb-3">
									<div class="col-4 col-sm-3">
										<label class="col-form-label" for="nom" >Nom<span class="text-danger">*</span></label>
									</div>		
									<div class="col-8 col-sm-9">
										<input type="text" class="form-control" id="nom" name="given-name" autocomplete="given-name" placeholder="Nom" required  pattern="[A-Za-zÀ-ÿ '-]{2,60}"
							title="Ha de contenir una longitud d'entre 2 i 60 caràcters"/>
									</div>	
								</div>
								
								<div class="row  mb-3">
									<div class="col-4 col-sm-3">
										 <label class="col-form-label" for="cognoms">Cognoms<span class="text-danger">*</span></label>
									</div>		
									<div class="col-8 col-sm-9">
										 <input type="text" class="form-control" id="cognoms" name="family-name" autocomplete="family-name" placeholder="Cognoms" required pattern="[A-Za-zÀ-ÿ '-]{2,60}"
							title="Ha de contenir una longitud d'entre 2 i 60 caràcters">
									</div>	
								</div>
								
								<div class="row mb-3 align-items-center">
									<div class="col-4 col-sm-3">
										  <label class="col-form-label" for="telefon">Telèfon mòbil</label>
									</div>		
									<div class="col-8 col-sm-9">
									<input type="tel" class="form-control" id="telefon" name="tel" autocomplete="tel" placeholder="Telèfon" pattern="[+]?[0-9]{9,15}" title="El número de telèfon és opcional i ha de ser vàlid (de 9 a 15 dígits, opcionalment precedit per un '+')">
									</div>
									<div class="invalid-feedback">
									   El número de telèfon és opcional i ha de ser vàlid (de 9 a 15 dígits, opcionalment precedit per un '+')
									</div>							
								</div>					
								
								<div class="row mb-3 align-items-center">
									<div class="col-4 col-sm-3">
										  <label class="col-form-label" for="correu">Correu electrònic<span class="text-danger">*</span></label>
									</div>		
									<div class="col-8 col-sm-9">
										 <input type="email" class="form-control" id="correu" name="email" autocomplete="email" placeholder="Correu electrònic" required title="El correu és obligatori">
									</div>							
								</div>
								
								<div class="row mb-3 align-items-center">							
									<div class="col-4 col-sm-3">
										  <label class="col-form-label" for="correuc">Confirmar correu electrònic<span class="text-danger">*</span></label>
									</div>		
									<div class="col-8 col-sm-9">
										 <input type="email" class="form-control" id="correuc" name="emailc" autocomplete="email" placeholder="Correu electrònic" required title="El correu és obligatori">
									</div>	
								</div>
							
							</div>
						</div>
					
						
						<div class="d-grid gap-2">
							<!-- PRODUCTION 
							<div class="g-recaptcha" data-sitekey="6LdsNEAqAAAAAPg-sosPiP7k4BsPcMgTFMfv1-PO" data-callback="EnableSubmitForm"></div>
							<button type="submit" id="submitForm" name="submitform" class="btn btn-lg btn-success" disabled="disabled">Enviar Avís <i class="bi bi-envelope-arrow-up  mx-5 fs-3"></i></button>							-->
				
							<!-- DEBUG -->
							<button type="submit" id="submitForm" name="submitform" class="btn btn-lg btn-success">Enviar Avís <i class="bi bi-envelope-arrow-up  mx-5 fs-3"></i></button>
						</div>
					</form>
				</div>
				<!--
				<div class="well pwell">
					<p>
					Us informem que també podeu enviar-nos avisos a través del 
					<a href="https://web.girona.cat/app" target="_blank">Girona App</a>,
					l'aplicació per a dispositius mòbils com telèfons o tauletres de l'Ajuntament de Girona. El personal de l'Oficina d'Informació i 
					Atenció Ciutadana també pot omplir el formulari si qualsevol ciutadà o ciutadana 
					s'hi adreça presencialment o bé truca al telèfon d'Informació Ciutadana: 972 419 010
					</p>

					<p>
					Vegeu la informació dels <a href="https://web.girona.cat/participacio/avisos/resultats" target="_blank">indicadors de la Bústia d'Avisos i els nostre compromís</a>. 
					</p>
				</div>
				
				<div class="divfooter">
					L'ús de la bústia d'avisos o suggeriments suposa el consentiment per a tractar les vostres dades personals per a la seva resolució. 
					No s'utilitzaran per a finalitats diferents ni es cediran a tercers sense el vostre consentiment excepte que una norma legal o 
					vosaltres mateixos ho autoritzeu.
					<br><br>
					L'Ajuntament de Girona, com a Responsable del Tractament, només els conservarà el temps indispensable per a la correcta gestió.
					<br><br>
					Podeu exercir els vostres drets d'accés, rectificació o supressió, limitació del tractament, oposició i, si és el cas, portabilitat 
					mitjançant sol·licitud adreçada o presentada al Registre General (plaça del Vi, 1, 17004-Girona) o Seu electrònica de l'Ajuntament de Girona 
					(<a href="https://seu.girona.cat" target="_blank">https://seu.girona.cat</a>).
					<br><br>
					Més informació a <a href="https://www.girona.cat/dadespersonals" target="_blank">www.girona.cat/dadespersonals</a>.
				</div>
				-->
			</div>
			
			<!-- Spinner overlay -->
			<div id="spinner-overlay">
			   <div class="d-flex align-items-center">
					<h3>Enviant...</h3>
					<div class="spinner-border text-primary ms-2" role="status">
						<span class="visually-hidden">Enviant ...</span>
					</div>
				</div>
			</div>
	
		</div>
	</div>

    <script>
	
		window.onload = function() {
			//initCamera();
		};

		// Llamar a la función para cargar Google Maps de manera asíncrona
		//loadGoogleMapsAPI(); //cal descomentar Google Maps lib 
		loadOpenStreetMapAPI(); //cal descomentar Open Maps 

    </script>

	<script>
	const spinnerOverlay = document.getElementById('spinner-overlay');

	// JavaScript per activar la validació de Bootstrap
	(function () {
		'use strict'

		// Obtenir tots els formularis als quals volem aplicar estils de validació Bootstrap
		var forms = document.querySelectorAll('.needs-validation')
		
		// Recorrem cada formulari i evitem que s'enviï si no és vàlid
		Array.prototype.slice.call(forms)
			.forEach(function (form) {
				form.addEventListener('submit', function (event) {
					if (!form.checkValidity()) {
						event.preventDefault()
						event.stopPropagation()
						
						// Buscar el primer camp no valid
						var firstInvalidField = form.querySelector(':invalid');
						if (firstInvalidField) {
							// Porta el focus al primer camp no valid
							firstInvalidField.focus();
						}
					} else {
						// Si totes les dades són vàlides, mostrar l'spinner
						spinnerOverlay.style.display = 'flex';
					}					

					form.classList.add('was-validated')
				}, false)
			})
	})()
	</script>

</body>
</html>
