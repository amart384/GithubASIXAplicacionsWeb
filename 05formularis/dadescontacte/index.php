<?php

//Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
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
 
	<!-- Enllaç a les icones awesome 4 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">	
	<!-- bootstrap per les caixes d'informació -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">	 
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
	<link rel="stylesheet" href="css/bastyle.css?v=1.15">
		
</head>
<body>
	<div class="container my-5">
		<h4 class="titolprincipal">Bústia d'avisos</h4>
		
		<!--En el siguiento codigo, añade el la parte inferior de caja, con el id camera, un boton redondo, de color blanco, que indique la captura de la imagen. Añade un efecto al boton que al pulsar indique que se ha pulsado el boton. Añade una rutina de jascript al pulsar el boton -->
		<div id="divcamera">
			<div class="dadesform">Fotografia el motiu de l'avís:</div>
			<video id="camera" autoplay playsinline width="100%"></video>
			<button class="capture-roundbutton" onclick="captureImage()">
			<i class="fa fa-camera"></i> 
			</button>
			<br/>
			<div id="divbuttonscaptureimage">
				<!--<button id="capture-button" onclick="captureImage()">Capturar Foto</button> <br/> -->
				<button id="load-button" onclick="loadImage()"> Imatge de la galeria del telèfon</button> <br/>
			</div>	
		</div>
		
		<div id="divimages">
			<div id="captured-image-container">
				<img id="captured-image" src="" alt="Foto capturada">
				<i class="delete-icon fa fa-trash" onclick="deleteCapturedImage()"></i> 
			</div>
			
			<div id="divbuttonscaptureimage-again">
				<button id="capture-button-again" onclick="ShowCaptureImageButtons()">Tornar Capturar/Carregar Foto</button> <br/>
			</div>		
		</div>
		
		<div id="divform">				

			<!-- Formulari per enviar la imatge i etiquetes -->
			<!-- formulari opcional amb https://www.yiiframework.com/ -->
			<form id="image-form" class="needs-validation" novalidate action="processform.php" method="POST" enctype="multipart/form-data">
			
			<div class="card mb-4 dadesform">
					<div class="card-header">
						<h5>Dades de l'avís</h5>
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
						
						<!-- Camps ocults per guardar latitut y longitut -->
						<input type="hidden" id="latitud" name="latitud">
						<input type="hidden" id="longitud" name="longitud">						
						<input type="hidden" id="cprt_API_KEY" name="cprt_API_KEY" value="c89b588b918303304c008b752306789854cd5ee27f307da525620855becb364b">		
											
						
						<div class="row mb-3">
							<div class="col-12 col-sm-12">
								<label class="col-form-label" for="adrecaavis">Adreça de l'avís:<span class="text-danger">*</span></label>
								<div class="navbar-nav" id="menuContainer">
									  <!-- El menú s'emplenarà dinàmicament -->
									</div>
								</nav>	

								<!-- The required attribute is not permitted on inputs with the readonly attribute specified -->
								<input type="text" class="form-control" id="adrecaavis" name="adrecaavis" required pattern="[A-Za-zÀ-ÿ '-]{2,200}" autocomplete="false"/>						
								
								<div class="form-group descripciooculta" id="textAreaGroup">
									<label for="explicatiu">Descriu l'avís:</label>
									<textarea id="explicatiu" class="form-control" rows="5" placeholder="Escriu una descripció..."></textarea>
								</div>
							</div>
						</div>

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
					</div>					
				</div>	
				
			
				<div class="card mb-4 dadesform">
					<div class="card-header">
						<h5>Dades de contacte</h5>
					</div>
					
					<div class="card-body">
					   
						<div class="row mb-3">
							<div class="col-4 col-sm-3">
								<label class="col-form-label" for="nom" >Nom<span class="text-danger">*</span></label>
							</div>		
							<div class="col-8 col-sm-9">
								<input type="text" class="form-control" id="nom" name="given-name" autocomplete="given-name" placeholder="Nom" required  pattern="[A-Za-zÀ-ÿ '-]{2,60}"
					title="Ha de contenir una longitud d'entre 2 i 60 caràcters">
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
								  <label class="col-form-label" for="telefon">Telèfon mòbil<span class="text-danger">*</span></label>
							</div>		
							<div class="col-8 col-sm-9">
							<input type="tel" class="form-control" id="telefon" name="tel" autocomplete="tel" placeholder="Telèfon" required pattern="[+]?[0-9]{9,15}" title="El número de telèfon és obligatori i ha de ser vàlid (de 9 a 15 dígits, opcionalment precedit per un '+')">
							</div>
							<div class="invalid-feedback">
							   El número de telèfon és obligatori i ha de ser vàlid (de 9 a 15 dígits, opcionalment precedit per un '+')
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
				
				<input type="hidden" id="image-data" name="image">
				<input type="hidden" id="selected-tags" name="tags">
				
				
				<button type="submit" name="submitform" id="submitForm" class="buttonlarge">Enviar Avís</button>
				
			</form>
		</div>
		
	</div>


	
</body>
</html>
