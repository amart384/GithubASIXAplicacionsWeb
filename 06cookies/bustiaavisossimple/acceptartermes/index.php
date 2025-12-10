<?php

//Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifiquem la cookie, 
if (isset($_COOKIE['baajgi_accept_cookies_privacy_terms']) && 
   $_COOKIE['baajgi_accept_cookies_privacy_terms'] == 'true') {

	//establim la cookie en un any de vida
	//realment estem renovant la cookie
	setcookie('baajgi_accept_cookies_privacy_terms', 'true', time() + (60 * 60 * 24 * 365), "/");
	
	header("Location: main.php");
	exit();
}

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
	
    <title>Bústia d'avisos - Girona</title>
	
	<!-- bootstrap per les caixes d'informació
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">	  -->
	 <!-- bootstrap -->
	<link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"/>	 
	<!-- bootstrap -->
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
	<!-- bootstrap icons -->
	<link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
	
    <style>
 
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
		
		
    </style>
</head>
<body>
	<div class="container my-5">
	  <div class="row">
            <div class="col-lg-8 col-sm-12 mx-auto">
				<form action="main.php" method="POST">	
					<div class="card">
						<div class="card-header bg-primary text-white text-center">
								<h3>Bústia d'avisos</h3>
						</div>
						<div class="card-body">
								<h3 class="card-title">Condicions del Servei</h3>
							
								<p class="card-text">Si us plau, accepteu les nostres polítiques de privadesa i galetes per continuar utilitzant l'aplicació.</p><br/>
								
									
								<div class="row  mb-3">
									<div class="col-1 col-sm-1">
									</div>
									<div class="col-2 col-sm-2">
										<input type="checkbox" class="checkbox-large" id="accept_cookies" name="accept_cookies" onchange="checkAcceptation()">
									</div>
									<div class="col-9 col-sm-9">
										<label for="accept_cookies">Accepto l'ús de <a href="https://web.girona.cat/avislegal/galetes" target="_blank">galetes</a></label>
									</div>			
								</div>
								<br/>
								<div class="row  mb-3">
									<div class="col-1 col-sm-1">
									</div>					
									<div class="col-2 col-sm-2">
										 <input type="checkbox" class="checkbox-large"  id="accept_privacy_terms" name="accept_privacy_terms" onchange="checkAcceptation()">
									</div>
									<div class="col-9 col-sm-9">
										<label for="accept_privacy_terms">Accepto la <a href="https://web.girona.cat/dadespersonals" target="_blank">política de privadesa </a> i <a href="https://web.girona.cat/avislegal">termes del servei</a></label>
									</div>			
								</div>									
								
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-1"> </div>                            
								<div class="col-4 d-grid">

									<!--<button type="button" class="btn btn-lg btn-success" id="submit-btn-refuse" name="submit-btn-refuse" >Rebutjar</button>-->
									<button type="Cancel" id="submit-btn-refuse" name="submit-btn-refuse" class="btn btn-lg btn-success">Rebutjar</button>

								</div>
								<div class="col-2"> </div>
								<div class="col-4 d-grid">  
									<!--<button type="button" class="btn btn-lg btn-success" id="submit-btn-accept" name="submit-btn-accept" disabled>Acceptar</button>-->
									<button type="submit" id="submit-btn-accept" name="submit-btn-accept" class="btn btn-lg btn-secondary" disabled>Aceptar</button>
									</div>
								<div class="col-1"> </div>                           
							</div>
						</div>		
					</div>	
				</form>				
			</div>
		</div>		
	</div>	

    <script>
        function checkAcceptation() {
            const acceptCookies = document.getElementById('accept_cookies').checked;
            const acceptPrivacy = document.getElementById('accept_privacy_terms').checked;
            const submitButton = document.getElementById('submit-btn-accept');
            
            // Habilitar el botón solo si ambos checkboxes están marcados
            if (acceptCookies && acceptPrivacy) {
                submitButton.disabled = false;
				submitButton.classList.remove("btn-secondary");
				submitButton.classList.add("btn-success");
            } else {
                submitButton.disabled = true;
				submitButton.classList.remove("btn-success");
				submitButton.classList.add("btn-secondary");
            }
        }		
    </script>
</body>
</html>